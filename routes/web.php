<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\HomeController;

// 1. HALAMAN DEPAN (Generator Publik) - Kita beri nama 'home'
Route::get('/', [HomeController::class, 'index'])->name('home');

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

    Route::get('/bulk-action', [AccountController::class, 'bulkView'])->name('bulk.view');
    Route::post('/bulk-import', [AccountController::class, 'import'])->name('bulk.import');
    Route::get('/bulk-export', [AccountController::class, 'export'])->name('bulk.export');

    Route::delete('/account/sell/{id}', [AccountController::class, 'sell'])->name('account.sell');

    Route::delete('/transactions/clear', [AccountController::class, 'clearTransactions'])->name('transactions.clear');
});

Route::get('/install-db-rahasia', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "<h1>MIGRASI SUKSES!</h1> <p>Tabel Transaksi berhasil ditambahkan.</p>";
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

Route::get('/tes-telegram', function () {
    $token = env('TELEGRAM_BOT_TOKEN');
    $chat_id = env('TELEGRAM_CHAT_ID');

    if (!$token) return "ERROR: TELEGRAM_BOT_TOKEN belum disetting di .env atau Vercel!";
    if (!$chat_id) return "ERROR: TELEGRAM_CHAT_ID belum disetting di .env atau Vercel!";

    try {
        $response = \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chat_id,
            'text' => "🔔 <b>TES KONEKSI BERHASIL!</b>\nBot Anda sudah terhubung.",
            'parse_mode' => 'HTML'
        ]);

        if ($response->successful()) {
            return "<h1>SUKSES! ✅</h1> <p>Cek Telegram Anda, seharusnya ada pesan masuk.</p>";
        } else {
            return "<h1>GAGAL! ❌</h1> <p>Telegram menolak pesan ini.</p><br><strong>Penyebab:</strong> " . $response->body();
        }
    } catch (\Exception $e) {
        return "<h1>ERROR SISTEM! ⚠️</h1>" . $e->getMessage();
    }
});

require __DIR__.'/auth.php';