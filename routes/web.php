<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. HALAMAN DEPAN (Generator Publik) - Kita beri nama 'home'
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. AREA KHUSUS MEMBER (Harus Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Data Akun)
    Route::get('/dashboard', [AccountController::class, 'index'])->name('dashboard');
    
    // Input Manual
    Route::get('/input', [AccountController::class, 'create'])->name('account.create');
    
    // Log Aktivitas
    Route::get('/activity-log', [AccountController::class, 'activityLog'])->name('account.log');

    // Proses Simpan & Hapus
    Route::post('/store', [AccountController::class, 'store'])->name('account.store');
    Route::delete('/delete/{id}', [AccountController::class, 'destroy'])->name('account.delete');

    // Profil Bawaan Laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MENU SETTINGS (Baru)
    Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
    Route::post('/settings', [AccountController::class, 'storeCategory'])->name('settings.store');
    Route::delete('/settings/{id}', [AccountController::class, 'destroyCategory'])->name('settings.delete');
});

require __DIR__.'/auth.php';