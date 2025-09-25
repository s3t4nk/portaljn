<?php

namespace App\Imports;

use App\Modules\HRIS\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Skip jika employee_number kosong
        if (empty($row['employee_number'])) {
            Log::warning('Skip baris: employee_number kosong');
            return null;
        }

        // Cek duplikat employee_number
        if (Employee::where('employee_number', $row['employee_number'])->exists()) {
            Log::warning('Skip duplikat employee_number: ' . $row['employee_number']);
            return null;
        }

        // Auto-generate email
        $email = !empty($row['email']) ? $row['email'] : $row['employee_number'] . '@jembatannusantara.co.id';

        // Cek atau buat user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $row['name'] ?? '',
                'password' => Hash::make('password123'),
            ]
        );

        // Cari ID relasi
        $branchId = \App\Modules\HRIS\Models\Branch::where('id', $row['branch_id'] ?? null)->value('id');
        $positionId = \App\Modules\HRIS\Models\Position::where('id', $row['position_id'] ?? null)->value('id');
        $unitId = !empty($row['unit_id'])
            ? \App\Modules\HRIS\Models\Unit::where('id', $row['unit_id'])->value('id')
            : null;

        // Mapping jenis kelamin
        $gender = Str::lower($row['gender'] ?? '') === 'perempuan' ? 'P' : 'L';

        // Mapping status pernikahan
        $maritalMap = [
            'belum_menikah' => 'belum_menikah',
            'menikah' => 'menikah',
            'janda' => 'cerai_mati',
            'duda' => 'cerai_hidup',
        ];
        $maritalStatus = $maritalMap[Str::lower($row['marital_status'] ?? '')] ?? 'belum_menikah';

        // Mapping status karyawan
        $employmentStatus = Str::lower($row['employment_status'] ?? '') === 'kontrak' ? 'kontrak' : 'tetap';

        return new Employee([
            'employee_number' => $row['employee_number'],
            'user_id' => $user->id,
            'branch_id' => $branchId,
            'department_id' => $branchId ? \App\Modules\HRIS\Models\Department::where('branch_id', $branchId)->value('id') : null,
            'unit_id' => $unitId,
            'position_id' => $positionId,
            'name' => $row['name'] ?? '',
            'gender' => $gender,
            'birth_place' => $row['birth_place'] ?? '',
            'birth_date' => \Carbon\Carbon::parse($row['birth_date'] ?? '1990-01-01'),
            'marital_status' => $maritalStatus,
            'religion' => $row['religion'] ?? 'Islam',
            'address' => $row['address'] ?? '',
            'phone' => $row['phone'] ?? '',
            'email' => $email,
            'emergency_contact_name' => $row['emergency_contact_name'] ?? '',
            'emergency_contact_relation' => $row['emergency_contact_relation'] ?? '',
            'emergency_contact_phone' => $row['emergency_contact_phone'] ?? '',
            'bank_name' => $row['bank_name'] ?? null,
            'bank_account_number' => $row['bank_account_number'] ?? null,
            'id_card_number' => $row['id_card_number'] ?? $row['employee_number'],
            'family_card_number' => $row['family_card_number'] ?? '',
            'npwp_number' => $row['npwp_number'] ?? null,
            'bpjs_ketenagakerjaan' => $row['bpjs_ketenagakerjaan'] ?? null,
            'bpjs_kesehatan' => $row['bpjs_kesehatan'] ?? null,
            'employment_status' => $employmentStatus,
            'joining_date' => \Carbon\Carbon::parse($row['joining_date'] ?? now()),
            'contract_start' => !empty($row['contract_start']) ? \Carbon\Carbon::parse($row['contract_start']) : null,
            'contract_end' => !empty($row['contract_end']) ? \Carbon\Carbon::parse($row['contract_end']) : null,
            'education_level' => $row['education_level'] ?? null,
            'major' => $row['major'] ?? null,
            'university' => $row['university'] ?? null,
            'description' => $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.employee_number' => 'required|max:255',
            '*.name' => 'required|string|max:255',
            '*.phone' => 'required|max:20',
            '*.branch_id' => 'required|exists:branches,id',
            '*.position_id' => 'required|exists:positions,id',
            '*.joining_date' => 'required|date',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.employee_number.required' => 'NIK wajib diisi',
            '*.name.required' => 'Nama lengkap wajib diisi',
        ];
    }
}