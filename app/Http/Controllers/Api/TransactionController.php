<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // PENTING: Untuk membuat token acak

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $userEmail = $request->user()->email; // Deteksi via Email (untuk sync pintar)

        $transactions = Transaction::with(['contact', 'counterparty', 'logs' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])
            ->where('creator_id', $userId)
            ->orWhere('counterparty_id', $userId)
            ->orWhereHas('contact', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhereHas('creator', function($q) use ($userEmail) { // Antisipasi duplikasi akun Google ID
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
            'token' => Str::random(12), // Tautan Unik
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
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Android akan mengirim file < 1MB
        ]);

        $userId = $request->user()->id;
        $transaction = Transaction::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('creator_id', $userId)
                  ->orWhere('counterparty_id', $userId);
            })->firstOrFail();

        $payment = (float) $request->amount;
        $newRemaining = max(0, $transaction->remaining_amount - $payment);
        
        $transaction->remaining_amount = $newRemaining;
        if ($newRemaining <= 0) {
            $transaction->status = 'PAID';
        }
        $transaction->save();

        // FITUR BARU: Simpan Gambar ke folder Publik
        $proofImagePath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filename = time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            // Simpan langsung ke public/uploads/proofs (Bypass Symlink)
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
            'status' => 'ACCEPTED'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dicatat',
            'data' => $transaction->fresh(['logs', 'contact', 'counterparty'])
        ]);
    }

    public function sync(Request $request, $id)
    {
        $userId = $request->user()->id;
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
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
    
    // FUNGSI BARU: Hapus Transaksi (Hanya Pembuat yang bisa)
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

        $transaction->delete(); // Ini otomatis akan menghapus riwayat cicilan karena setting 'cascadeOnDelete' di migrasi

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus secara permanen.'
        ]);
    }
}