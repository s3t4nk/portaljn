<?php

use Illuminate\Support\Facades\Route;

// ===========================
// === AUTH ROUTES (Breeze) ===
// ===========================
require __DIR__.'/auth.php';

// ===========================
// === ROOT REDIRECT ===
// ===========================
// Jika akses http://127.0.0.1:8000/, langsung ke login
Route::redirect('/', '/login');

// ===========================
// === PROTECTED ROUTES ===
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/portal', function () {
        return view('portal.dashboard');
    })->name('portal.dashboard');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// ===========================
// === MODUL ROUTES ===
// ===========================
if (file_exists(__DIR__.'/modules/hris.php')) {
    require __DIR__.'/modules/hris.php';
}

if (file_exists(__DIR__.'/modules/finance.php')) {
    require __DIR__.'/modules/finance.php';
}

if (file_exists(__DIR__.'/modules/engineering.php')) {
    require __DIR__.'/modules/engineering.php';
}

if (file_exists(__DIR__.'/modules/procurement.php')) {
    require __DIR__.'/modules/procurement.php';
}

Route::get('/simulate-salary', function () {
    $employee = \App\Modules\HRIS\Models\Employee::first();
    $period = now()->format('Y-m');

    // Hitung seperti di atas
    $base = $employee->position?->salaryGrade?->base_salary ?? 0;
    $components = collect();
    $total = $base;

    foreach (\App\Modules\HRIS\Models\SalaryComponent::where('is_active', true)->get() as $comp) {
        if (/* logic shouldApply */ true) {
            $amount = $comp->type === 'percentage' ? ($base * $comp->amount / 100) : $comp->amount;
            $components->push(['name' => $comp->name, 'amount' => $amount]);
            $total += $amount;
        }
    }

    \App\Modules\HRIS\Models\EmployeeSalaryHistory::updateOrCreate(
        ['employee_id' => $employee->id, 'period' => $period],
        [
            'base_salary' => $base,
            'components' => $components,
            'total_salary' => $total,
            'status' => 'published'
        ]
    );

    return "Gaji untuk {$period} berhasil disimpan.";
});