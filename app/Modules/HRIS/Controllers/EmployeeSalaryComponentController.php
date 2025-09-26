<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Employee;
use App\Modules\HRIS\Models\SalaryComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryComponentController extends Controller
{
    // 1) halaman daftar pegawai
    public function listEmployees()
    {
        $employees = Employee::with(['position', 'unit'])->orderBy('name')->get();
        return view('modules.hris.employee_salary_component.list', compact('employees'));
    }

    // 2) halaman manage per pegawai
    public function index($employeeId)
    {
        $employee = Employee::with(['position', 'unit'])->findOrFail($employeeId);

        // semua komponen master (untuk select)
        $components = SalaryComponent::where('is_active', 1)->orderBy('name')->get();
        // Semua komponen gaji (untuk pilihan tambah baru)
        $allComponents = SalaryComponent::where('is_active', 1)->get();

        // ambil row khusus employee dari pivot (jika ada)
        $rows = DB::table('employee_salary_component')
            ->where('employee_id', $employeeId)
            ->join('salary_components', 'salary_components.id', '=', 'employee_salary_component.salary_component_id')
            ->select(
                'employee_salary_component.id',
                'employee_salary_component.salary_component_id',
                'employee_salary_component.amount',
                'salary_components.name as component_name',
                'salary_components.category'
            )
            ->get();

        // transform menjadi struktur yang view (menggunakan property salaryComponent->name)
        $employeeComponents = $rows->map(function ($r) {
            return (object)[
                'id' => $r->id,
                'salary_component_id' => $r->salary_component_id,
                'amount' => $r->amount,
                'salaryComponent' => (object)[
                    'id' => $r->salary_component_id,
                    'name' => $r->component_name,
                    'category' => $r->category,
                ],
            ];
        });

        return view('modules.hris.employee_salary_component.index', compact('employee', 'components', 'employeeComponents','allComponents'));
    }

    // 3) store / add (insert or update if already exists)
    public function store(Request $request, $employeeId)
    {
        $request->validate([
            'salary_component_id' => 'required|exists:salary_components,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // jika sudah ada untuk employee + component, update; else insert
        $exists = DB::table('employee_salary_component')
            ->where('employee_id', $employeeId)
            ->where('salary_component_id', $request->salary_component_id)
            ->first();

        if ($exists) {
            DB::table('employee_salary_component')
                ->where('id', $exists->id)
                ->update(['amount' => $request->amount, 'updated_at' => now()]);
        } else {
            DB::table('employee_salary_component')->insert([
                'employee_id' => $employeeId,
                'salary_component_id' => $request->salary_component_id,
                'amount' => $request->amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('hris.employee-salary-component.index', $employeeId)
            ->with('success', 'Komponen gaji berhasil disimpan.');
    }

    // 4) update by pivot id
    public function update(Request $request, $employeeId, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:0']);

        DB::table('employee_salary_component')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update(['amount' => $request->amount, 'updated_at' => now()]);

        return redirect()->route('hris.employee-salary-component.index', $employeeId)
            ->with('success', 'Komponen gaji berhasil diperbarui.');
    }

    // 5) destroy
    public function destroy($employeeId, $id)
    {
        DB::table('employee_salary_component')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        return redirect()->route('hris.employee-salary-component.index', $employeeId)
            ->with('success', 'Komponen gaji berhasil dihapus.');
    }
}
