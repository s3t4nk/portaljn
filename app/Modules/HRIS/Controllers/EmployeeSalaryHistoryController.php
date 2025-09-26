<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use App\Modules\HRIS\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\HRIS\Models\SalaryComponent;

class EmployeeSalaryHistoryController extends Controller
{

    private function calculateAutoComponents($employee)
    {
        $components = [];

        // Ambil semua komponen aktif
        $allComponents = \App\Modules\HRIS\Models\SalaryComponent::where('is_active', 1)->get();

        foreach ($allComponents as $comp) {
            if ($this->shouldApplyComponent($comp, $employee)) {
                $amount = $comp->type == 'percentage'
                    ? ($employee->position?->salaryGrade?->base_salary ?? 0) * ($comp->amount / 100)
                    : $comp->amount;

                $components[] = [
                    'name' => $comp->name,
                    'category' => $comp->category,
                    'amount' => $amount,
                    'is_auto' => true
                ];
            }
        }

        return $components;
    }

    private function shouldApplyComponent($component, $employee)
    {
        if ($component->applicable_to === 'grade') {
            $grade = $employee->position?->salaryGrade?->grade;
            if ($grade) {
                if ($component->min_grade && $grade < $component->min_grade) return false;
                if ($component->max_grade && $grade > $component->max_grade) return false;
                return true;
            }
        }
        if ($component->applicable_to === 'position' && $component->position_id == $employee->position_id) {
            return true;
        }
        if ($component->applicable_to === 'employee_type') {
            return $component->employee_type === $employee->position?->employee_type ||
                $component->employee_type === 'semua';
        }
        return false;
    }

    public function downloadSlip($id)
    {
        // Load tanpa relasi salaryComponents dulu
        $employee = Employee::with(['position', 'unit'])->findOrFail($id);
        $history = $employee->getLastSalaryAttribute();

        if (!$history) {
            return back()->with('error', 'Data gaji belum tersedia.');
        }

        // === Ambil komponen MANUAL (dari pivot) ===
        $manualRows = DB::table('employee_salary_component as esc')
            ->join('salary_components as sc', 'sc.id', '=', 'esc.salary_component_id')
            ->where('esc.employee_id', $id)
            ->select('sc.name', 'sc.category', 'esc.amount')
            ->get();

        $manualComponents = $manualRows->map(fn($r) => [
            'name' => $r->name,
            'category' => $r->category,
            'amount' => $r->amount,
            'source' => 'manual'
        ]);

        $manualNames = $manualComponents->pluck('name')->toArray();

        // === Ambil komponen OTOMATIS ===
        $autoComponents = collect();
        $allComponents = SalaryComponent::where('is_active', 1)->get();

        foreach ($allComponents as $comp) {
            if (in_array($comp->name, $manualNames)) continue;
            if ($this->shouldApplyComponent($comp, $employee)) {
                $base = $employee->position?->salaryGrade?->base_salary ?? 0;
                $amount = $comp->type === 'percentage'
                    ? $base * ($comp->amount / 100)
                    : $comp->amount;
                $autoComponents->push([
                    'name' => $comp->name,
                    'category' => $comp->category,
                    'amount' => $amount,
                    'source' => 'auto'
                ]);
            }
        }

        $finalComponents = $manualComponents->merge($autoComponents);
        $allowances = $finalComponents->where('category', 'allowance');
        $deductions = $finalComponents->where('category', 'deduction');

        $tunjanganTotal = $allowances->sum('amount');
        $potonganTotal = $deductions->sum('amount');
        $grossIncome = ($history->base_salary ?? 0) + $tunjanganTotal;
        $netIncome = $grossIncome - $potonganTotal;

        // Logo
        $logoPath = public_path('images/logo_kop_surat.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        // Ambil karyawan yang jabatannya mengandung "Manager SDM"
        $gmEmployee = Employee::with('position')
            ->whereHas('position', function ($query) {
                $query->where('name', 'like', '%Manager SDM%');
            })
            ->first();

        $gmData = $gmEmployee
            ? [
                'name' => $gmEmployee->name,
                'position' => $gmEmployee->position->name,
                'nik' => $gmEmployee->employee_number,
                'address' => $gmEmployee->address ?? 'Jl. Pahlawan No. 112-114 Surabaya',
            ]
            : [
                'name' => 'TRI HARIYONO',
                'position' => 'MANAGER SDM PT. JEMBATAN NUSANTARA',
                'nik' => '11306006',
                'address' => 'Jl. Pahlawan No. 112-114 Surabaya',
            ];

        $creator = Auth::user();
        $creatorData = [
            'name' => $creator?->name ?? 'ACHMAD AFANDI T',
            'position' => 'Pembuat Daftar Gaji',
            'nik' => 'CREATOR001',
        ];

        // ✅ KIRIM DATA PRIMITIF, BUKAN MODEL
        $data = [
            'employee_name' => $employee->name,
            'employee_number' => $employee->employee_number,
            'position_name' => $employee->position?->name ?? '-',
            'unit_name' => $employee->unit?->name ?? '-',
            'branch_name' => $employee->branch?->name ?? 'PT. JEMBATAN NUSANTARA PUSAT',
            'history' => $history,
            'allowances' => $allowances->values(),
            'deductions' => $deductions->values(),
            'grossIncome' => $grossIncome,
            'netIncome' => $netIncome,
            'potonganTotal' => $potonganTotal,
            'company' => [
                'name' => 'PT. JEMBATAN NUSANTARA',
                'logo' => $logoBase64
            ],
            'gm_data' => $gmData,
            'creator_data' => $creatorData,
        ];

        $pdf = Pdf::loadView('modules.hris.employees.salary_slip_darat', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download("slip-gaji-{$employee->employee_number}-{$history->period}.pdf");
    }
}
