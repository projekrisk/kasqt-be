<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/google', [AuthController::class, 'googleLogin']);

Route::middleware('auth:sanctum')->group(function () {    
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });

    Route::post('/user/fcm-token', [AuthController::class, 'updateFcmToken']);

    Route::post('/user/phone', [AuthController::class, 'updatePhone']);
    Route::post('/contacts/sync-phonebook', [ContactController::class, 'syncPhonebook']);
    
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::put('/contacts/{id}', [ContactController::class, 'update']); 
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::post('/transactions/{id}/pay', [TransactionController::class, 'pay']);
    
    Route::post('/transactions/{id}/approve/{log_id}', [TransactionController::class, 'approvePayment']);
    Route::post('/transactions/{id}/reject/{log_id}', [TransactionController::class, 'rejectPayment']);
    
    Route::post('/transactions/{token}/sync', [TransactionController::class, 'sync']);
    
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
});