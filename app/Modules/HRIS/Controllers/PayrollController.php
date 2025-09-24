<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Employee;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', date('Y-m'));
        $payrolls = EmployeeSalaryHistory::with('employee')
            ->where('period', $period)
            ->latest()
            ->paginate(20);

        return view('modules.hris.payroll.index', compact('payrolls', 'period'));
    }

    public function generate(Request $request)
    {
        $period = $request->input('period', date('Y-m'));
        $employees = Employee::with(['position.salaryGrade', 'salaryComponents'])->get();

        foreach ($employees as $emp) {
            // Skip jika sudah ada histori untuk periode ini
            if (EmployeeSalaryHistory::where('employee_id', $emp->id)->where('period', $period)->exists()) {
                continue;
            }

            $base = $emp->position?->salaryGrade?->base_salary ?? 0;
            $components = [];
            $total = $base;

            // Ambil tunjangan khusus karyawan
            foreach ($emp->salaryComponents as $comp) {
                $amount = $comp->pivot->amount ?? 0;
                $components[] = [
                    'name' => $comp->name,
                    'amount' => $amount
                ];
                $total += $amount;
            }

            EmployeeSalaryHistory::create([
                'employee_id' => $emp->id,
                'period' => $period,
                'base_salary' => $base,
                'components' => json_encode($components),
                'total_salary' => $total,
                'status' => 'draft'
            ]);
        }

        return redirect()->back()->with('success', '✅ Payroll periode ' . $period . ' berhasil digenerate.');
    }

    
    public function approveMass(Request $request)
    {
        $ids = $request->input('ids', []);
        EmployeeSalaryHistory::whereIn('id', $ids)->update(['status' => 'published']);
        return back()->with('success', '✅ ' . count($ids) . ' slip gaji berhasil dipublish.');
    }

    public function publish($id)
    {
        $history = EmployeeSalaryHistory::findOrFail($id);
        if ($history->status !== 'draft') {
            return back()->with('error', 'Hanya status draft yang bisa dipublish.');
        }
        $history->update(['status' => 'published']);
        return back()->with('success', '✅ Slip gaji telah dipublish.');
    }

    public function pay($id)
    {
        $history = EmployeeSalaryHistory::findOrFail($id);
        if ($history->status !== 'published') {
            return back()->with('error', 'Hanya status published yang bisa dibayar.');
        }
        $history->update(['status' => 'paid']);
        return back()->with('success', '✅ Gaji telah dibayarkan.');
    }
}
