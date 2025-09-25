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
        $employee = Employee::with(['position', 'unit', 'salaryComponents'])->findOrFail($id);
        $history = $employee->getLastSalaryAttribute();

        if (!$history) {
            return back()->with('error', 'Data gaji belum tersedia.');
        }

        // Ambil komponen gaji via relasi pivot
        $components = $employee->salaryComponents;

        $allowances = $components->filter(fn($c) => $c->category === 'allowance');
        $deductions = $components->filter(fn($c) => $c->category === 'deduction');

        $tunjanganTotal = $allowances->sum(fn($a) => $a->pivot->amount);
        $potonganTotal  = $deductions->sum(fn($d) => $d->pivot->amount);

        $grossIncome = ($history->base_salary ?? 0) + $tunjanganTotal;
        $netIncome   = $grossIncome - $potonganTotal;

        // Logo → base64
        $logoPath = public_path('images/logo_kop_surat.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        // Data GM
        $gmData = [
            'name' => 'TRI HARIYONO',
            'position' => 'MANAGER SDM PT. JEMBATAN NUSANTARA',
            'nik' => '11306006',
            'address' => 'Jl. Pahlawan No. 112-114 Surabaya',
        ];

        // Data creator
        $creator = Auth::user();
        $creatorData = [
            'name' => $creator?->name ?? 'ACHMAD AFANDI T',
            'position' => 'Pembuat Daftar Gaji',
            'nik' => 'CREATOR001',
        ];

        $data = [
            'employee' => $employee,
            'history' => $history,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'grossIncome' => $grossIncome,
            'netIncome' => $netIncome,
            'potonganTotal' => $potonganTotal,
            'tunjanganTotal' => $tunjanganTotal,
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
