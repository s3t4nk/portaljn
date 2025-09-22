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
        $employees = Employee::with(['branch', 'department', 'position'])->get();
        return view('modules.hris.employees.index', compact('employees'));
    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $positions = Position::orderBy('name')->get();
        return view('modules.hris.employees.create', compact('branches', 'departments', 'units', 'positions'));
    }

    public function store_lama(Request $request)
    {
        // Validasi disesuaikan nanti di multi-step
        $data = $request->all();
        Employee::create($data);

        return redirect()->route('hris.employees.index')
            ->with('success', 'Data karyawan berhasil disimpan.');
    }

    public function store1(Request $request)
    {
        $request->validate([
            'employee_number' => 'required|unique:employees',
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'nik'   => 'nullable|unique:employee',
            'id_card_number' => 'required|unique:employees',
            'position_id' => 'required|exists:positions,id'
        ]);

        // Auto-generate email jika belum ada
        $email = $request->email ?? "{$request->employee_number}@jembatannusantara.co.id";

        // Cek apakah email sudah ada di users
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => Hash::make('password123'), // Bisa diubah saat first login
            ]);
        }

        // Dapatkan position
        $position = Position::find($request->position_id);

        // Tentukan role berdasarkan logika bisnis
        $role = 'staff_darat'; // default

        if ($position->employee_type === 'laut') {
            $role = 'crew_laut';
        }

        if ($position->is_management) {
            $role = 'manager';
        }

        // Cek apakah departemen HR → assign admin_hr
        if ($position->name === 'Admin HR' || str_contains(strtolower($position->name), 'hr')) {
            $role = 'admin_hr';
        }

        // Pastikan role ada, lalu assign
        $user->assignRole($role);

        // Simpan ke employees
        $employee = Employee::create(array_merge($request->all(), [
            'user_id' => $user->id,
            'email' => $email // simpan juga di employee untuk konsistensi
        ]));

        return redirect()->route('hris.employees.index')
            ->with('success', "Karyawan {$employee->name} berhasil ditambahkan & akun dibuat.");
    }

    public function store(Request $request)
    {
        // Validasi SEMUA field penting
        $validated = $request->validate([
            // Data Pribadi
            'employee_number' => 'required|unique:employees,employee_number',
            'name' => 'required|string|max:255',
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

            // Kontak Darurat
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:50',
            'emergency_contact_phone' => 'required|string|max:20',

            'description' => 'nullable|string'
        ]);

        // Auto-generate email jika kosong
        $email = $request->email ?? "{$request->employee_number}@jembatannusantara.co.id";

        // Cek apakah user sudah ada
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => Hash::make('password123'),
            ]);
        }

        // Pastikan email ikut disimpan di employees
        $validated['email'] = $email;

        // Simpan ke employees
        Employee::create(array_merge($validated, [
            'user_id' => $user->id
        ]));

        return redirect()->route('hris.employees.index')
            ->with('success', "Karyawan {$request->name} berhasil ditambahkan.");
    }

    // public function show(Employee $employee)
    // {
    //     $employee->load(['branch', 'department', 'unit', 'position']);
    //     return view('modules.hris.employees.show', compact('employee'));
    // }

    public function show(Employee $employee)
    {
        $employee->load(['branch', 'department', 'unit', 'position.salaryGrade']);

        // Hitung gaji pokok + komponen
        $base = $employee->position?->salaryGrade?->base_salary ?? 0;
        $components = collect();

        foreach (SalaryComponent::where('is_active', true)->get() as $comp) {
            if ($this->shouldApplyComponent($comp, $employee)) {
                $amount = $comp->type === 'percentage'
                    ? ($base * $comp->amount / 100)
                    : $comp->amount;

                $components->push([
                    'name' => $comp->name,
                    'type' => $comp->type,
                    'value' => $amount
                ]);
            }
        }

        $total = $base + $components->sum('value');

        // Filter & paginate histori gaji
        $period = request('period');
        $query = $employee->salaryHistories();

        if ($period) {
            $query->where('period', $period);
        }

        $salaryHistories = $query->orderBy('period', 'desc')->paginate(5);

        // Simpan tab aktif
        $activeTab = request('tab') ?? 'personal';

        return view('modules.hris.employees.show', compact(
            'employee',
            'base',
            'components',
            'total',
            'salaryHistories',
            'activeTab'
        ));
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

    public function edit(Employee $employee)
    {
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $positions = Position::orderBy('name')->get();
        return view('modules.hris.employees.edit', compact('employee', 'branches', 'departments', 'units', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());
        return redirect()->route('hris.employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('hris.employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
