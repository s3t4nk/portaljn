<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImportSalaryHistory extends Command
{
    protected $signature = 'import:salary-history {file}';
    protected $description = 'Impor histori gaji dari file CSV';

    public function handle()
    {
        $path = $this->argument('file');

        if (!File::exists($path)) {
            $this->error("File tidak ditemukan: $path");
            return 1;
        }

        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data); // ambil header

        $this->withProgressBar($data, function ($row) use ($header) {
            try {
                $record = array_combine($header, $row);

                // Validasi minimal
                if (!$record['employee_id'] || !$record['period']) {
                    $this->warn("Skip: employee_id atau period kosong");
                    return;
                }

                EmployeeSalaryHistory::updateOrCreate(
                    [
                        'employee_id' => $record['employee_id'],
                        'period' => $record['period']
                    ],
                    [
                        'base_salary' => (float)$record['base_salary'],
                        'components' => json_decode($record['components'], true),
                        'total_salary' => (float)$record['total_salary'],
                        'status' => $record['status'] ?? 'draft',
                        'created_at' => $record['created_at'] ?? now(),
                        'updated_at' => $record['updated_at'] ?? now(),
                    ]
                );

            } catch (\Exception $e) {
                $this->error("Error pada baris: " . json_encode($row));
                $this->error($e->getMessage());
            }
        });

        $this->info("\nImpor selesai!");
        return 0;
    }
}