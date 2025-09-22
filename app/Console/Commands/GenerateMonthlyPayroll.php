<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\HRIS\Models\Employee;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use App\Modules\HRIS\Models\SalaryComponent;
use Carbon\Carbon;

class GenerateMonthlyPayroll extends Command
{
    // Nama command yang akan dipanggil: php artisan payroll:generate
    protected $signature = 'payroll:generate';

    // Deskripsi saat ketik php artisan
    protected $description = 'Generate draft payroll untuk semua karyawan aktif pada bulan berjalan';

    public function handle()
    {
        // Tentukan periode: Y-m (contoh: 2025-10)
        $period = now()->format('Y-m');

        // Ambil semua karyawan aktif (yang statusnya bukan nonaktif)
        $employees = Employee::whereNotIn('employment_status', ['nonaktif', 'keluar'])->get();

        // Hitung total yang akan diproses
        $totalGenerated = 0;

        // Loop setiap karyawan
        foreach ($employees as $employee) {
            // Lewati jika sudah ada data untuk periode ini
            if (EmployeeSalaryHistory::where('employee_id', $employee->id)
                ->where('period', $period)->exists()) {
                continue;
            }

            // Hitung gaji pokok dari salary_grade
            $baseSalary = $employee->position?->salaryGrade?->base_salary ?? 0;

            // Kumpulkan komponen tunjangan
            $components = collect();

            // Ambil semua komponen aktif
            foreach (SalaryComponent::where('is_active', true)->get() as $comp) {
                // Cek apakah komponen ini berlaku untuk karyawan ini
                if ($this->shouldApplyComponent($comp, $employee)) {
                    $amount = $comp->type === 'percentage'
                        ? ($baseSalary * $comp->amount / 100)
                        : $comp->amount;

                    $components->push([
                        'name' => $comp->name,
                        'type' => $comp->type,
                        'value' => (float)$amount
                    ]);
                }
            }

            // Hitung total gaji kotor
            $totalSalary = $baseSalary + $components->sum('value');

            // Simpan sebagai draft
            EmployeeSalaryHistory::create([
                'employee_id' => $employee->id,
                'period' => $period,
                'base_salary' => $baseSalary,
                'components' => $components->toArray(),
                'total_salary' => $totalSalary,
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $totalGenerated++;
        }

        // Tampilkan hasil
        $this->info("✅ Draft payroll untuk periode {$period} berhasil dibuat.");
        $this->info("Total karyawan: {$employees->count()} | Baru ditambahkan: {$totalGenerated}");
    }

    /**
     * Cek apakah komponen gaji berlaku untuk karyawan ini
     */
    private function shouldApplyComponent($component, $employee)
    {
        $position = $employee->position;

        if (!$position) return false;

        switch ($component->applicable_to) {
            case 'grade':
                $grade = $position->salaryGrade?->grade;
                if (!$grade) return false;
                if ($component->min_grade && $grade < $component->min_grade) return false;
                if ($component->max_grade && $grade > $component->max_grade) return false;
                return true;

            case 'position':
                return $component->position_id == $position->id;

            case 'employee_type':
                $empType = $position->employee_type; // darat/laut
                return $component->employee_type === 'semua' || $component->employee_type === $empType;

            default:
                return false;
        }
    }
}