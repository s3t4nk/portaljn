<?php

namespace App\Modules\HRIS\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Employee;
use App\Modules\HRIS\Models\Branch;
use App\Modules\HRIS\Models\Department;
use App\Modules\HRIS\Models\Unit;
use App\Modules\HRIS\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Modules\HRIS\Models\SalaryComponent;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['branch', 'department', 'position'])->latest()->get();
        return view('modules.hris.employees.index', compact('employees'));
    }

    public function create()
    {
        $branches = \App\Modules\HRIS\Models\Branch::all();
        $positions = \App\Modules\HRIS\Models\Position::all();
        return view('modules.hris.employees.create', compact('branches', 'positions'));
    }

    public function store(Request $request)
    {
        // Validasi SEMUA field penting
        $validated = $request->validate([
            // Data Pribadi
            'employee_number' => 'required|unique:employees,employee_number',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // opsional, max 2MB
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'religion' => 'required|string|max:50',
            'blood_type' => 'nullable|string|max:3',
            'marital_status' => 'required|in:belum_menikah,menikah,cerai_hidup,cerai_mati',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:users,email',

            // Pendidikan
            'education_level' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'university' => 'nullable|string|max:100',

            // Pekerjaan
            'branch_id' => 'required|exists:branches,id',
            'department_id' => 'required|exists:departments,id',
            'unit_id' => 'nullable|exists:units,id',
            'position_id' => 'required|exists:positions,id',
            'employment_status' => 'required|in:tetap,kontrak,magang,honor',
            'joining_date' => 'required|date',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date',

            // Dokumen
            'id_card_number' => 'required|unique:employees,id_card_number',
            'family_card_number' => 'nullable|string',
            'npwp_number' => 'nullable|string',
            'bpjs_ketenagakerjaan' => 'nullable|string',
            'bpjs_kesehatan' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|regex:/^[0-9]+$/|max:20',

            // Kontak Darurat
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:50',
            'emergency_contact_phone' => 'required|string|max:20',

            'description' => 'nullable|string'
        ]);

        // Auto-generate email jika kosong
        $email = $request->email ?? "{$request->employee_number}@jembatannusantara.co.id";

        // Cek apakah user sudah ada
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => bcrypt('password123'),
            ]);
        }

        // Handle upload foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employee-photos', 'public');
        }

        // Simpan ke employees
        Employee::create(array_merge($validated, [
            'user_id' => $user->id,
            'photo' => $photoPath,
            'email' => $email,
        ]));

        return redirect()->route('hris.employees.index')
            ->with('success', "Karyawan {$request->name} berhasil ditambahkan.");
    }

    public function show(Employee $employee)
    {
        // Ambil data sertifikat digital
        $certificates = $employee->certificates;

        // Ambil histori gaji terakhir
        $lastSalary = $employee->salaryHistories()->latest('period')->first();

        // Hitung struktur gaji (gaji pokok + komponen)
        $base = $employee->position?->salaryGrade?->base_salary ?? 0;
        $components = [];
        $total = $base;

        // Ambil komponen gaji khusus karyawan ini
        foreach ($employee->salaryComponents as $comp) {
            $amount = $comp->pivot->amount ?? 0;
            $components[] = [
                'name' => $comp->name,
                'value' => $amount
            ];
            $total += $amount;
        }

        // Default active tab
        $activeTab = request('tab', 'personal');

        return view('modules.hris.employees.show', compact(
            'employee',
            'certificates',      // untuk tab Dokumen
            'lastSalary',        // opsional
            'base',              // gaji pokok
            'components',        // tunjangan
            'total',             // total estimasi
            'activeTab'          // tab aktif
        ));
    }

    public function edit(Employee $employee)
    {
        $branches = \App\Modules\HRIS\Models\Branch::all();
        $positions = \App\Modules\HRIS\Models\Position::all();
        return view('modules.hris.employees.edit', compact('employee', 'branches', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        // Validasi (sesuaikan kebutuhan)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee->update($validated);

        return redirect()->route('hris.employees.show', $employee)
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('hris.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
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

}