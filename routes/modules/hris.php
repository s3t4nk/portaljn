<?php
use Illuminate\Support\Facades\Log;
Log::info('🔧 DEBUG: Memulai eksekusi hris.php');
use Illuminate\Support\Facades\Route;
use App\Modules\HRIS\Controllers\HrisController;
use App\Modules\HRIS\Controllers\Admin\MenuManagementController;
use App\Modules\HRIS\Controllers\BranchController;
use App\Modules\HRIS\Controllers\DepartmentController;
use App\Modules\HRIS\Controllers\UnitController;
use App\Modules\HRIS\Controllers\PositionController;
use App\Modules\HRIS\Controllers\SalaryGradeController;
use App\Modules\HRIS\Controllers\SalaryComponentController;
use App\Modules\HRIS\Controllers\EmployeeController;
use App\Modules\HRIS\Controllers\PayrollController;
use App\Modules\HRIS\Controllers\EmployeeSalaryHistoryController;
//use Illuminate\Support\Facades\Log;

Log::info('✅ use statement berhasil');


// Grup utama HRIS
Route::middleware(['auth'])->prefix('hris')->as('hris.')->group(function () {
    
     Log::info('✅ Grup admin dimulai');
    // Dashboard & Resource lainnya
    Route::get('/dashboard', [HrisController::class, 'dashboard'])->name('dashboard');

    // Semua route admin hanya untuk super_admin
    Route::middleware(['role:super_admin'])->prefix('admin')->as('admin.')->group(function () {
         Log::info('✅ Route menu.index terdaftar');
        // === MANAJEMEN MENU ===
        Route::get('/menu', [MenuManagementController::class, 'index'])->name('menu.index');
        Log::info('✅ Route update.menu terdaftar');
        // Modul
        Route::get('/menu/module/create', [MenuManagementController::class, 'createModule'])->name('menu.module.create');
        Route::post('/menu/module', [MenuManagementController::class, 'storeModule'])->name('menu.module.store');
        Route::get('/menu/module/{module}/edit', [MenuManagementController::class, 'editModule'])->name('menu.module.edit');
        //Route::put('/menu/module/{module}', [MenuManagementController::class, 'updateModule'])->name('menu.module.update');
        Route::put('/menu/module/{module}', [MenuManagementController::class, 'updateModule'])
    ->name('menu.update.module');
        Route::delete('/menu/module/{module}', [MenuManagementController::class, 'destroyModule'])->name('menu.module.destroy');

        // Menu
        Route::get('/menu/create', [MenuManagementController::class, 'createMenu'])->name('menu.menu.create');
        Route::post('/menu', [MenuManagementController::class, 'storeMenu'])->name('menu.menu.store');
        Route::get('/menu/{menu}/edit', [MenuManagementController::class, 'editMenu'])->name('menu.menu.edit');
        //Route::put('/menu/{menu}', [MenuManagementController::class, 'updateMenu'])->name('menu.menu.update');
        Route::put('/menu/{menu}', [MenuManagementController::class, 'updateMenu'])->name('menu.update.menu');
        Route::delete('/menu/{menu}', [MenuManagementController::class, 'destroy'])->name('menu.menu.destroy');
    });

    // Resource routes lainnya (branches, departments, dll)
    // ✅ Branch. Resource route: semua pakai prefix hris.
    Route::resource('branches', BranchController::class)->names([
        'index' => 'branches.index',
        'create' => 'branches.create',
        'store' => 'branches.store',
        'edit' => 'branches.edit',
        'update' => 'branches.update',
        'destroy' => 'branches.destroy'
    ]);

    // ✅ Department
    Route::resource('departments', DepartmentController::class)->names([
        'index' => 'departments.index',
        'create' => 'departments.create',
        'store' => 'departments.store',
        'edit' => 'departments.edit',
        'update' => 'departments.update',
        'destroy' => 'departments.destroy'
    ]);

    // Unit
    Route::resource('units', UnitController::class)->names([
        'index' => 'units.index',
        'create' => 'units.create',
        'store' => 'units.store',
        'edit' => 'units.edit',
        'update' => 'units.update',
        'destroy' => 'units.destroy'
    ]);

    // position
    Route::resource('positions', PositionController::class)->names([
        'index' => 'positions.index',
        'create' => 'positions.create',
        'store' => 'positions.store',
        'edit' => 'positions.edit',
        'update' => 'positions.update',
        'destroy' => 'positions.destroy'
    ]);

    Route::resource('salary-grades', SalaryGradeController::class)->names('salary_grades');


    Route::resource('salary-components', SalaryComponentController::class)->names('salary_components');

    // Employee
    Route::resource('employees', EmployeeController::class)->names('employees');

    Route::prefix('payroll')->as('payroll.')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('index');
        Route::post('/{payroll}/publish', [PayrollController::class, 'publish'])->name('publish');
        Route::post('/{payroll}/pay', [PayrollController::class, 'pay'])->name('pay');
        Route::post('payroll/approve-mass', [PayrollController::class, 'approveMass'])->name('payroll.approve-mass');
    });
    Route::get('employees/{id}/slip', [EmployeeSalaryHistoryController::class, 'downloadSlip'])
        ->name('employees.slip');
    // ...
});