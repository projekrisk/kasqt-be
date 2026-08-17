<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Halaman Kebijakan & Dukungan
Route::get('/privasi', function () { return view('privacy'); });
Route::get('/ketentuan', function () { return view('terms'); });
Route::get('/bantuan', function () { return view('help'); });

// FITUR BARU: Rute Halaman Tangkapan Deep Link Transaksi
Route::get('/trc/{token}', function ($token) {
    // Arahkan ke file tampilan (view) blade
    return view('transaction_landing', ['token' => $token]);
});