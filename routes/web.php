<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===============================================
// 1. Halaman Umum (bisa diakses semua orang)
// ===============================================

Route::get('/', function () {
    return view('welcome');
});

// MENU PELANGGAN – Client-side (yang sudah kita buat cantik + waiting page)
Route::get('/meja/{no?}', function ($no = 1) {
    return view('customer.menu');                    // ← file: resources/views/customer/menu.blade.php
})->where('no', '[0-9]+')->name('customer.menu');

Route::get('/waiting', function () {
    return view('customer.waiting');                 // ← file: resources/views/customer/waiting.blade.php
})->name('customer.waiting');

// ===============================================
// 2. Halaman yang butuh login (dari Breeze/Jetstream)
// ===============================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================================
// 3. Auth routes (login, register, forgot password, dll)
// ===============================================

require __DIR__.'/auth.php';