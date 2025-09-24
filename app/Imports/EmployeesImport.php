<?php

namespace App\Imports;

use App\Modules\HRIS\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Skip jika NIK kosong
        if (empty($row['nik'])) {
            return null;
        }

        // Cek duplikat NIK
        if (Employee::where('employee_number', $row['nik'])->exists()) {
            Log::warning('Skip duplikat NIK: ' . $row['nik']);
            return null;
        }

        // Auto-generate email
        $email = !empty($row['email']) ? $row['email'] : $row['nik'] . '@jembatannusantara.co.id';

        // Cek atau buat user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $row['nama_lengkap'],
                'password' => Hash::make('password123'),
            ]
        );

        // Cari ID relasi
        $branchId = \App\Modules\HRIS\Models\Branch::where('name', $row['id_cabang'])->value('id');
        $positionId = \App\Modules\HRIS\Models\Position::where('name', $row['id_jabatan'])->value('id');
        $unitId = !empty($row['id_unit'])
            ? \App\Modules\HRIS\Models\Unit::where('name', $row['id_unit'])->value('id')
            : null;

        // Mapping jenis kelamin
        $gender = strtolower($row['jenis_kelamin'] ?? '') === 'perempuan' ? 'P' : 'L';

        // Mapping status pernikahan
        $maritalMap = [
            'belum menikah' => 'belum_menikah',
            'menikah' => 'menikah',
            'janda' => 'cerai_mati',
            'duda' => 'cerai_hidup',
        ];
        $maritalStatus = $maritalMap[strtolower($row['status_pernikahan'] ?? '')] ?? 'belum_menikah';

        // Mapping status karyawan
        $employmentStatus = strtolower($row['status_karyawan'] ?? '') === 'kontrak' ? 'kontrak' : 'tetap';

        return new Employee([
            'employee_number' => $row['nik'],
            'user_id' => $user->id,
            'branch_id' => $branchId,
            'department_id' => $branchId ? \App\Modules\HRIS\Models\Department::where('branch_id', $branchId)->value('id') : null,
            'unit_id' => $unitId,
            'position_id' => $positionId,
            'name' => $row['nama_lengkap'],
            'gender' => $gender,
            'birth_place' => $row['tempat_lahir'] ?? '',
            'birth_date' => \Carbon\Carbon::parse($row['tanggal_lahir']),
            'marital_status' => $maritalStatus,
            'religion' => $row['agama'] ?? 'Islam',
            'address' => $row['address'] ?? '',
            'phone' => $row['phone'],
            'email' => $email,
            'emergency_contact_name' => $row['emergency_contact_name'] ?? '',
            'emergency_contact_relation' => $row['relationship'] ?? '',
            'emergency_contact_phone' => $row['emergency_contact_phone'] ?? '',
            'bank_name' => $row['bank_name'] ?? null,
            'bank_account_number' => $row['bank_account'] ?? null,
            'id_card_number' => $row['nik_ktp'] ?? $row['nik'],
            'bpjs_ketenagakerjaan' => $row['bpjs_ketenagakerjaan'] ?? null,
            'bpjs_kesehatan' => $row['bpjs_kesehatan'] ?? null,
            'employment_status' => $employmentStatus,
            'joining_date' => \Carbon\Carbon::parse($row['tanggal_masuk']),
            'contract_start' => !empty($row['tanggal_tetap']) ? \Carbon\Carbon::parse($row['tanggal_tetap']) : null,
            'contract_end' => !empty($row['resign_date']) ? \Carbon\Carbon::parse($row['resign_date']) : null,
            'education_level' => $row['pendidikan'] ?? null,
            'major' => $row['jurusan'] ?? null,
            'university' => $row['institusi'] ?? null,
            'description' => $row['Alasan Resign'] ?? $row['notes'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nik' => 'required|string|max:255',
            '*.nama_lengkap' => 'required|string|max:255',
            '*.phone' => 'required|string|max:20',
            '*.id_cabang' => 'required|string',
            '*.id_jabatan' => 'required|string',
            '*.tanggal_masuk' => 'required|date',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nik.required' => 'NIK wajib diisi',
            '*.nama_lengkap.required' => 'Nama lengkap wajib diisi',
        ];
    }
}