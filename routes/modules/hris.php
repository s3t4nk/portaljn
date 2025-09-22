<?php

use Illuminate\Support\Facades\Route;
use App\Modules\HRIS\Controllers\HrisController;
use App\Modules\HRIS\Controllers\BranchController;
use App\Modules\HRIS\Controllers\DepartmentController;
use App\Modules\HRIS\Controllers\UnitController;
use App\Modules\HRIS\Controllers\PositionController;
use App\Modules\HRIS\Controllers\SalaryGradeController;
use App\Modules\HRIS\Controllers\SalaryComponentController;
use App\Modules\HRIS\Controllers\EmployeeController;
use App\Modules\HRIS\Controllers\PayrollController;
use App\Modules\HRIS\Controllers\EmployeeSalaryHistoryController;
use App\Modules\HRIS\Controllers\Admin\MenuManagementController;
use App\Modules\HRIS\Models\Position;
use App\Modules\HRIS\Models\SalaryGrade;

Route::middleware(['auth'])->prefix('hris')->as('hris.')->group(function () {
    // ✅ Benar: route /hris/dashboard → nama: hris.dashboard
    Route::get('/dashboard', [HrisController::class, 'dashboard'])->name('dashboard');

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

    // Semua route admin hanya untuk super_admin
    Route::middleware(['role:super_admin'])->prefix('admin')->as('admin.')->group(function () {

        // Manajemen Modul & Menu
        Route::get('/menu', [MenuManagementController::class, 'index'])->name('menu.index');

        // Modul
        Route::post('/menu/module', [MenuManagementController::class, 'storeModule'])->name('menu.storeModule');
        Route::get('/menu/module/create', [MenuManagementController::class, 'createModule'])->name('menu.createModule');
        Route::get('/menu/module/{module}/edit', [MenuManagementController::class, 'editModule'])->name('menu.editModule');
        Route::put('/menu/module/{module}', [MenuManagementController::class, 'updateModule'])->name('menu.updateModule');
        Route::delete('/menu/module/{module}', [MenuManagementController::class, 'destroyModule'])->name('menu.destroyModule');

        // Menu
        Route::post('/menu', [MenuManagementController::class, 'storeMenu'])->name('menu.storeMenu');
        Route::get('/menu/{menu}/edit', [MenuManagementController::class, 'editMenu'])->name('menu.editMenu');
        Route::put('/menu/{menu}', [MenuManagementController::class, 'updateMenu'])->name('menu.updateMenu');
        Route::delete('/menu/{menu}', [MenuManagementController::class, 'destroy'])->name('menu.destroy');
    });

});


// API untuk dropdown dinamis
Route::prefix('api')->group(function () {
    Route::get('/departments', function (\Illuminate\Http\Request $request) {
        $branchId = $request->query('branch_id');
        $departments = \App\Modules\HRIS\Models\Department::where('branch_id', $branchId)
            ->orderBy('name')
            ->get(['id', 'name']);
        return response()->json($departments);
    });

    Route::get('/units', function (\Illuminate\Http\Request $request) {
        $deptId = $request->query('department_id');
        $units = \App\Modules\HRIS\Models\Unit::where('department_id', $deptId)
            ->orderBy('name')
            ->get(['id', 'name']);
        return response()->json($units);
    });

    // Route::get('salary-history/{id}/slip', [EmployeeSalaryHistoryController::class, 'downloadSlip'])
    // ->name('salary_history.slip');
});
