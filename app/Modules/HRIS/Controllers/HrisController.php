<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Employee;
use App\Modules\HRIS\Models\Branch;
use Illuminate\Support\Facades\DB;

class HrisController extends Controller
{
    public function dashboard()
    {
        // Statistik Utama
        $totalEmployees = Employee::count();
        $totalBranches  = Branch::count();

        // Karyawan Darat vs Laut
        $employeeTypes = Employee::with('position')
            ->get()
            ->groupBy(function ($emp) {
                return $emp->position?->employee_type ?? 'tidak_diketahui';
            })
            ->map->count();

        $daratCount = $employeeTypes['darat'] ?? 0;
        $lautCount  = $employeeTypes['laut']  ?? 0;

        // Jumlah Pria & Wanita
        $genderStats = Employee::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        $priaCount = $genderStats['L'] ?? 0;
        $wanitaCount = $genderStats['P'] ?? 0;

        // Karyawan per Cabang
        $employeesByBranch = DB::table('employees as e')
            ->join('branches as b', 'e.branch_id', '=', 'b.id')
            ->select('b.name as branch_name', DB::raw('count(*) as total'))
            ->groupBy('b.id', 'b.name')
            ->orderByDesc('total')
            ->get();

        // Jika ada tabel employee_salary_histories
        $publishedPayrolls = \App\Modules\HRIS\Models\EmployeeSalaryHistory::where('status', 'published')->count();

        // Jika ada fitur cuti
        $pendingLeaves = 0; // Ganti nanti saat model LeaveRequest dibuat

        return view('modules.hris.dashboard', compact(
            'totalEmployees',
            'totalBranches',
            'daratCount',
            'lautCount',
            'priaCount',
            'wanitaCount',
            'employeesByBranch',
            'publishedPayrolls',
            'pendingLeaves'
        ));
    }
}
