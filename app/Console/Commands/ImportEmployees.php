<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;
use Illuminate\Support\Facades\Log;

class ImportEmployees extends Command
{
    protected $signature = 'employees:import {file : Path to the Excel/CSV file}';
    protected $description = 'Import karyawan dari file Excel/CSV';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return 1;
        }

        $this->info("🚀 Mulai proses import...");

        try {
            Excel::import(new EmployeesImport, $filePath);
            $this->info("✅ Data berhasil diimpor!");
        } catch (\Exception $e) {
            Log::error('Import gagal: ' . $e->getMessage());
            $this->error("❌ Gagal import: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}