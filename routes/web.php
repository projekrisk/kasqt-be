<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// FITUR BARU: Rute Halaman Tangkapan Deep Link Transaksi
Route::get('/trc/{token}', function ($token) {
    // Arahkan ke file tampilan (view) blade
    return view('transaction_landing', ['token' => $token]);
});