<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;

// Login dan Register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Halaman setelah pengguna login
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Transaksi
    Route::resource('transaksi', TransactionController::class)
        ->parameters(['transaksi' => 'transaction']);

    // Kategori
    Route::resource('kategori', CategoryController::class)
        ->except(['show'])
        ->parameters(['kategori' => 'category']);

    // Riwayat transaksi
    Route::get('/riwayat', [TransactionController::class, 'history'])
        ->name('transaksi.history');
});
