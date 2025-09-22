<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use App\Modules\HRIS\Models\Employee;

class EmployeeSalaryHistorySeeder extends Seeder
{
    public function run()
    {
        // Ambil karyawan pertama sebagai contoh (Anda bisa sesuaikan)
        $employee = Employee::first();
        if (!$employee) {
            $this->command->error("Tidak ada data karyawan. Jalankan dulu: php artisan db:seed EmployeeSeeder");
            return;
        }

        $baseSalary = $employee->position?->salaryGrade?->base_salary ?? 10500000;

        // Komponen tunjangan (bisa dari SalaryComponent, tapi kita hardcode dulu untuk demo)
        $components = [
            ['name' => 'Tunjangan Jabatan', 'value' => 1750000],
            ['name' => 'Tunjangan Mobilitas', 'value' => 400000]
        ];

        $totalAllowance = array_sum(array_column($components, 'value'));
        $totalSalary = $baseSalary + $totalAllowance;

        // Periode: Januari hingga Agustus 2025
        $start = now()->startOfYear()->year(2025);
        for ($i = 1; $i <= 8; $i++) {
            $period = $start->copy()->addMonths($i - 1)->format('Y-m');

            EmployeeSalaryHistory::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'period' => $period
                ],
                [
                    'base_salary' => $baseSalary,
                    'components' => $components,
                    'total_salary' => $totalSalary,
                    'status' => 'published',
                    'created_at' => $period . '-01 10:00:00',
                    'updated_at' => $period . '-01 10:00:00',
                ]
            );
        }

        $this->command->info("✅ Berhasil: 8 histori gaji (Jan–Agustus 2025) untuk karyawan {$employee->name}");
    }
}