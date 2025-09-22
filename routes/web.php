<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// ===========================
// === AUTH ROUTES (Breeze) ===
// ===========================
require __DIR__.'/auth.php';

// ===========================
// === ROOT REDIRECT ===
// ===========================
Route::redirect('/', '/login');

// ===========================
// === PROTECTED ROUTES ===
// ===========================
Route::middleware(['auth'])->group(function () {
    // 1. Portal Dashboard
    Route::get('/portal', function () {
        return view('portal.dashboard');
    })->name('portal.dashboard');

    // 2. Test Route (Hanya untuk Development)
    Route::get('/test-admin', function () {
        return '✅ HALAMAN TEST ADMIN BERHASIL DIBUKA!';
    })->name('test.admin.index');

    Route::get('/test-admin/create', function () {
        return view('test.create');
    })->name('test.admin.create');

    Route::post('/test-admin/store', function () {
        return redirect()->route('test.admin.index')->with('success', 'Data berhasil disimpan!');
    })->name('test.admin.store');

    // ====== MUAT SEMUA MODUL DI SINI ======
    $modules = ['hris', 'finance', 'engineering', 'procurement'];

    foreach ($modules as $mod) {
        $path = __DIR__."/modules/{$mod}.php";
        
        if (file_exists($path)) {
            require $path;
            Log::info("✅ Module {$mod}.php berhasil dimuat");
        } else {
            Log::warning("❌ File module {$mod}.php tidak ditemukan di: {$path}");
        }
    }

});