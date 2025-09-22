<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index()
{
    $period = request('period', now()->format('Y-m'));

    // Cek apakah periode valid (tidak di masa depan)
    $currentPeriod = now()->format('Y-m');
    if ($period > $currentPeriod) {
        return back()->with('error', "Periode {$period} tidak valid. Hanya bisa proses periode sekarang atau sebelumnya.");
    }

    $payrolls = EmployeeSalaryHistory::with('employee')
        ->where('period', $period)
        ->whereIn('status', ['draft', 'published'])
        ->orderBy('status', 'desc')
        ->paginate(25);

    return view('modules.hris.payroll.index', compact('payrolls', 'period'));
}

    public function publish(Request $request, EmployeeSalaryHistory $payroll)
    {
        // Hanya boleh publish jika status draft
        if ($payroll->status !== 'draft') {
            return back()->with('error', 'Hanya draft yang bisa dipublish.');
        }

        $payroll->update(['status' => 'published']);

        return back()->with('success', 'Payroll berhasil dipublish!');
    }

    public function pay(Request $request, EmployeeSalaryHistory $payroll)
    {
        // Hanya boleh bayar jika sudah published
        if ($payroll->status !== 'published') {
            return back()->with('error', 'Hanya payroll yang sudah dipublish yang bisa dibayar.');
        }

        $payroll->update(['status' => 'paid']);

        return back()->with('success', 'Gaji telah dibayar!');
    }
}