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

        // FITUR DIPERBARUI: Tambahkan 'creator' agar pihak lawan tahu nama pembuatnya
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

    public function pay(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = $request->user()->id;
        $transaction = Transaction::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('creator_id', $userId)
                  ->orWhere('counterparty_id', $userId);
            })->firstOrFail();

        $payment = (float) $request->amount;
        $isCreator = ($userId === $transaction->creator_id);
        
        // JIKA PEMBUAT YANG CATAT = LANGSUNG DITERIMA. JIKA PIHAK LAWAN = PENDING.
        $logStatus = $isCreator ? 'ACCEPTED' : 'PENDING';

        // FITUR BARU: UPLOAD GAMBAR KE FOLDER PUBLIC
        $proofImagePath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/proofs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $proofImagePath = 'uploads/proofs/' . $filename;
        }

        $transaction->logs()->create([
            'transaction_id' => $transaction->id,
            'user_id' => $userId,
            'amount' => $payment,
            'proof_image' => $proofImagePath,
            'status' => $logStatus
        ]);

        // JIKA PEMBUAT YANG CATAT, SISA TAGIHAN LANGSUNG BERKURANG
        if ($isCreator) {
            $newRemaining = max(0, $transaction->remaining_amount - $payment);
            $transaction->remaining_amount = $newRemaining;
            if ($newRemaining <= 0) {
                $transaction->status = 'PAID';
            }
            $transaction->save();
        }

        // KIRIM NOTIFIKASI KE PIHAK LAWAN TEPAT SASARAN
        $otherUserId = $isCreator ? $transaction->counterparty_id : $transaction->creator_id;
        if ($otherUserId) {
            $otherUser = \App\Models\User::find($otherUserId);
            if ($otherUser && $otherUser->fcm_token) {
                $rupiah = number_format($payment, 0, ',', '.');
                if ($isCreator) {
                    $title = "Pembayaran Baru 💰";
                    $body = "Pembayaran sebesar Rp {$rupiah} telah dicatat untuk: " . $transaction->description;
                } else {
                    $title = "Menunggu Persetujuan ⏳";
                    $body = "Pihak lawan mengajukan cicilan Rp {$rupiah}. Silakan setujui di aplikasi.";
                }
                \App\Services\FcmService::sendNotification($otherUser->fcm_token, $title, $body);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $isCreator ? 'Pembayaran berhasil dicatat' : 'Pembayaran diajukan, menunggu persetujuan',
            'data' => $transaction->fresh(['logs', 'contact', 'counterparty'])
        ]);
    }

    // FITUR BARU: TERIMA PEMBAYARAN
    public function approvePayment(Request $request, $trxId, $logId)
    {
        $userId = $request->user()->id;
        $transaction = Transaction::where('id', $trxId)->where('creator_id', $userId)->firstOrFail();
        $log = $transaction->logs()->where('id', $logId)->where('status', 'PENDING')->firstOrFail();

        $log->update(['status' => 'ACCEPTED']);

        // Kurangi tagihan sekarang setelah disetujui
        $newRemaining = max(0, $transaction->remaining_amount - $log->amount);
        $transaction->remaining_amount = $newRemaining;
        if ($newRemaining <= 0) $transaction->status = 'PAID';
        $transaction->save();

        if ($transaction->counterparty_id) {
            $cp = \App\Models\User::find($transaction->counterparty_id);
            if ($cp && $cp->fcm_token) \App\Services\FcmService::sendNotification($cp->fcm_token, "Disetujui ✅", "Pembayaran Rp " . number_format($log->amount, 0, ',', '.') . " diterima.");
        }

        return response()->json(['success' => true, 'message' => 'Disetujui']);
    }

    // FITUR BARU: TOLAK PEMBAYARAN
    public function rejectPayment(Request $request, $trxId, $logId)
    {
        $userId = $request->user()->id;
        $transaction = Transaction::where('id', $trxId)->where('creator_id', $userId)->firstOrFail();
        $log = $transaction->logs()->where('id', $logId)->where('status', 'PENDING')->firstOrFail();

        $log->update(['status' => 'DISPUTED']);

        if ($transaction->counterparty_id) {
            $cp = \App\Models\User::find($transaction->counterparty_id);
            if ($cp && $cp->fcm_token) \App\Services\FcmService::sendNotification($cp->fcm_token, "Ditolak ❌", "Bukti/nominal pembayaran Rp " . number_format($log->amount, 0, ',', '.') . " ditolak.");
        }

        return response()->json(['success' => true, 'message' => 'Ditolak']);
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