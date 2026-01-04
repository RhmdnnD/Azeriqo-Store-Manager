<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;

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

    Route::get('/manage-workers', [WorkerController::class, 'index'])->name('workers.index');
    Route::post('/manage-workers', [WorkerController::class, 'store'])->name('workers.store');
    Route::delete('/manage-workers/{id}', [WorkerController::class, 'destroy'])->name('workers.delete');

    Route::put('/account/{id}', [AccountController::class, 'update'])->name('account.update');

    Route::delete('/activity-log/clear', [AccountController::class, 'clearLogs'])->name('log.clear');
});

Route::get('/install-db-rahasia', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);

        \App\Models\User::create([
            'name' => 'Owner Azeriqo',
            'email' => 'admin@azeriqo.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
        ]);
        return "SUKSES! Database Terinstall.";
    } catch (\Exception $e) {
        return "ERROR: " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';