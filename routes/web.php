<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privasi', function () { return view('privacy'); });
Route::get('/ketentuan', function () { return view('terms'); });
Route::get('/bantuan', function () { return view('help'); });

Route::get('/trc/{token}', function ($token) {
    return view('transaction_landing', ['token' => $token]);
});