<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $userEmail = $request->user()->email; 

        $transactions = Transaction::with(['contact', 'counterparty', 'creator', 'logs' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])
            ->where('creator_id', $userId)
            ->orWhere('counterparty_id', $userId)
            ->orWhereHas('contact', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhereHas('creator', function($q) use ($userEmail) { 
                $q->where('email', $userEmail);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:hutang,piutang',
            'amount' => 'required|numeric|min:1',
            'contact_id' => 'nullable|exists:contacts,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $transaction = Transaction::create([
            'creator_id' => $request->user()->id,
            'contact_id' => $request->contact_id,
            'counterparty_id' => null,
            'type' => $request->type,
            'amount' => $request->amount,
            'remaining_amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'ACTIVE',
            'description' => $request->description,
            'token' => Str::random(12), 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dicatat',
            'data' => $transaction->load(['contact', 'counterparty', 'logs'])
        ], 201);
    }

    private function sendFCM($deviceToken, $title, $body) 
    {
        if (!$deviceToken) return;
        try {
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('firebase-credentials.json'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();
            $token = $client->getAccessToken();

            $credentials = json_decode(file_get_contents(storage_path('firebase-credentials.json')), true);
            $projectId = $credentials['project_id'];

            \Illuminate\Support\Facades\Http::withToken($token['access_token'])
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => [
                        'token' => $deviceToken,
                        'notification' => [ 'title' => $title, 'body' => $body ],
                        'data' => [ 'action' => 'REFRESH_TRANSACTIONS' ]
                    ]
                ]);
        } catch (\Exception $e) { \Illuminate\Support\Facades\Log::error("FCM Error: " . $e->getMessage()); }
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = $request->user()->id;
        $transaction = Transaction::where('id', $id)->firstOrFail();

        $proofImagePath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filename = time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/proofs');
            
            if (!file_exists($destinationPath)) { mkdir($destinationPath, 0755, true); }
            $file->move($destinationPath, $filename);
            $proofImagePath = 'uploads/proofs/' . $filename;
        }

        $isCreator = $transaction->creator_id === $userId;
        $logStatus = $isCreator ? 'ACCEPTED' : 'PENDING';

        $log = $transaction->logs()->create([
            'transaction_id' => $transaction->id,
            'user_id' => $userId,
            'amount' => $request->amount,
            'proof_image' => $proofImagePath,
            'status' => $logStatus
        ]);

        if ($isCreator) {
            $newRemaining = max(0, $transaction->remaining_amount - $request->amount);
            $transaction->update(['remaining_amount' => $newRemaining, 'status' => $newRemaining <= 0 ? 'PAID' : 'ACTIVE']);
            
            if ($transaction->counterparty_id) {
                $this->sendFCM($transaction->counterparty->fcm_token, "Pembaruan Transaksi", "Tagihan Anda telah diperbarui sebesar Rp " . number_format($request->amount, 0, ',', '.'));
            }
        } else {
            $this->sendFCM($transaction->creator->fcm_token, "Menunggu Persetujuan", $request->user()->name . " mencatat pembayaran baru. Cek sekarang!");
        }

        return response()->json(['success' => true, 'message' => 'Berhasil dicatat', 'data' => $transaction->fresh(['logs', 'contact', 'counterparty'])]);
    }

    public function approvePayment(Request $request, $id, $log_id)
    {
        $transaction = Transaction::where('id', $id)->where('creator_id', $request->user()->id)->firstOrFail();
        $log = $transaction->logs()->where('id', $log_id)->where('status', 'PENDING')->firstOrFail();

        $log->update(['status' => 'ACCEPTED']);
        
        $newRemaining = max(0, $transaction->remaining_amount - $log->amount);
        $transaction->update(['remaining_amount' => $newRemaining, 'status' => $newRemaining <= 0 ? 'PAID' : 'ACTIVE']);

        if ($transaction->counterparty_id) {
            $this->sendFCM($transaction->counterparty->fcm_token, "Pembayaran Disetujui ✅", "Pembayaran sebesar Rp " . number_format($log->amount, 0, ',', '.') . " telah dikonfirmasi.");
        }

        return response()->json(['success' => true]);
    }

    public function rejectPayment(Request $request, $id, $log_id)
    {
        $transaction = Transaction::where('id', $id)->where('creator_id', $request->user()->id)->firstOrFail();
        $log = $transaction->logs()->where('id', $log_id)->where('status', 'PENDING')->firstOrFail();

        $log->update(['status' => 'DISPUTED']);

        if ($transaction->counterparty_id) {
            $this->sendFCM($transaction->counterparty->fcm_token, "Pembayaran Ditolak ❌", "Bukti/nominal pembayaran Anda disanggah. Silakan periksa kembali.");
        }

        return response()->json(['success' => true]);
    }

    public function sync(Request $request, $token)
    {
        $userId = $request->user()->id;
        
        $transaction = Transaction::where('token', $token)->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan atau tautan tidak valid.'], 404);
        }

        if ($transaction->creator_id === $userId) {
            return response()->json(['success' => false, 'message' => 'Ini adalah transaksi buatan Anda sendiri.'], 400);
        }

        if ($transaction->counterparty_id !== null) {
            if ($transaction->counterparty_id === $userId) {
                return response()->json(['success' => false, 'message' => 'Transaksi ini sudah tertaut di akun Anda.'], 400);
            }
            return response()->json(['success' => false, 'message' => 'Transaksi ini sudah ditautkan oleh orang lain.'], 400);
        }

        $transaction->counterparty_id = $userId;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ditautkan! Transaksi muncul di beranda Anda.',
            'data' => $transaction->fresh(['logs', 'contact', 'counterparty'])
        ]);
    }
    
    public function destroy(Request $request, $id)
    {
        $userId = $request->user()->id;
        $transaction = Transaction::where('id', $id)->first();
        
        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }
        
        if ($transaction->creator_id !== $userId) {
            return response()->json(['success' => false, 'message' => 'Hanya pembuat yang dapat menghapus transaksi ini.'], 403);
        }

        $transaction->delete(); 

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus secara permanen.'
        ]);
    }
}