<?php

use Illuminate\Support\Facades\Route;
use App\Modules\HRIS\Controllers\Admin\MenuManagementController;

// Letakkan SEMUA route di dalam grup hris.
Route::middleware(['auth'])->prefix('hris')->as('hris.')->group(function () {

    Route::middleware(['role:super_admin'])->prefix('admin')->as('admin.')->group(function () {

        // === MANAJEMEN MODUL ===
        Route::get('/menu', [MenuManagementController::class, 'index'])->name('menu.index');

        Route::get('/menu/module/create', [MenuManagementController::class, 'createModule'])->name('menu.module.create');
        Route::post('/menu/module', [MenuManagementController::class, 'storeModule'])->name('menu.module.store');
        Route::get('/menu/module/{module}/edit', [MenuManagementController::class, 'editModule'])->name('menu.module.edit');
        Route::put('/menu/module/{module}', [MenuManagementController::class, 'updateModule'])->name('menu.module.update');
        Route::delete('/menu/module/{module}', [MenuManagementController::class, 'destroyModule'])->name('menu.module.destroy');

        // === MANAJEMEN MENU ===
        Route::get('/menu/create', [MenuManagementController::class, 'createMenu'])->name('menu.menu.create');
        Route::post('/menu', [MenuManagementController::class, 'storeMenu'])->name('menu.menu.store');
        Route::get('/menu/{menu}/edit', [MenuManagementController::class, 'editMenu'])->name('menu.menu.edit');
        Route::put('/menu/{menu}', [MenuManagementController::class, 'updateMenu'])->name('menu.menu.update');
        Route::delete('/menu/{menu}', [MenuManagementController::class, 'destroy'])->name('menu.menu.destroy');
    });
});