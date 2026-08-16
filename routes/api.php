<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute API (Endpoint untuk Aplikasi Android Kasqt)
|--------------------------------------------------------------------------
*/

// Endpoint Publik (Tidak butuh token Sanctum)
Route::post('/auth/google', [AuthController::class, 'googleLogin']);

// Endpoint yang Diproteksi (Wajib kirim token Sanctum di Header)
Route::middleware('auth:sanctum')->group(function () {
    
    // Cek profil user yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });

    Route::post('/user/fcm-token', [AuthController::class, 'updateFcmToken']);

    Route::post('/user/phone', [AuthController::class, 'updatePhone']);
    Route::post('/contacts/sync-phonebook', [ContactController::class, 'syncPhonebook']);
    

    // Logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Endpoint Kontak
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
    // FITUR BARU: Edit Kontak
    Route::put('/contacts/{id}', [ContactController::class, 'update']); 
    // FITUR BARU: Hapus Kontak
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

    // Endpoint Transaksi
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::post('/transactions/{id}/pay', [TransactionController::class, 'pay']);
    
    // FITUR BARU: Setujui & Tolak Pembayaran
    Route::post('/transactions/{trxId}/logs/{logId}/approve', [TransactionController::class, 'approvePayment']);
    Route::post('/transactions/{trxId}/logs/{logId}/reject', [TransactionController::class, 'rejectPayment']);
    
    // FITUR BARU: Tautkan transaksi ke pihak kedua (Sync)
    Route::post('/transactions/{token}/sync', [TransactionController::class, 'sync']);
    
    // FITUR BARU: Hapus Transaksi
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
});