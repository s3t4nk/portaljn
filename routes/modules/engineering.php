<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/engineering', function () {
        return '<h1>Modul Keuangan - Dalam Pengembangan</h1>';
    })->name('engineering.dashboard');
});