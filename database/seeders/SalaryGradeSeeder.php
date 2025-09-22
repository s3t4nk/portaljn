<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\HRIS\Models\SalaryGrade;

class SalaryGradeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['grade' => 7, 'class' => 'C', 'subclass' => 1, 'code' => 'VII-C1', 'base_salary' => 25000000, 'description' => 'DIREKTUR UTAMA, GENERAL MANAGER'],
            ['grade' => 6, 'class' => 'C', 'subclass' => 1, 'code' => 'VI-C1', 'base_salary' => 22000000, 'description' => 'BRANCH MANAGER (Kelas A)'],
            ['grade' => 6, 'class' => 'C', 'subclass' => 2, 'code' => 'VI-C2', 'base_salary' => 21500000, 'description' => 'EXPERTISE'],
            ['grade' => 6, 'class' => 'A', 'subclass' => 1, 'code' => 'VI-A1', 'base_salary' => 20000000, 'description' => 'MANAGER'],
            ['grade' => 5, 'class' => 'B', 'subclass' => 1, 'code' => 'V-B1', 'base_salary' => 18000000, 'description' => 'ASSISTANT BRANCH MANAGER, SPESIALIS'],
            ['grade' => 5, 'class' => 'A', 'subclass' => 1, 'code' => 'V-A1', 'base_salary' => 16000000, 'description' => 'ASSISTANT MANAGER'],
            ['grade' => 4, 'class' => 'C', 'subclass' => 1, 'code' => 'IV-C1', 'base_salary' => 14000000, 'description' => 'SUPERVISOR (Kelas A)'],
            ['grade' => 4, 'class' => 'B', 'subclass' => 1, 'code' => 'IV-B1', 'base_salary' => 13500000, 'description' => 'SUPERVISOR (Kelas B)'],
            ['grade' => 4, 'class' => 'A', 'subclass' => 1, 'code' => 'IV-A1', 'base_salary' => 13000000, 'description' => 'SUPERVISOR (Kelas C)'],
            ['grade' => 3, 'class' => 'C', 'subclass' => 3, 'code' => 'III-C3', 'base_salary' => 11000000, 'description' => 'KASIR (Kelas A)'],
            ['grade' => 3, 'class' => 'B', 'subclass' => 3, 'code' => 'III-B3', 'base_salary' => 10500000, 'description' => 'KASIR (Kelas B)'],
            ['grade' => 3, 'class' => 'B', 'subclass' => 1, 'code' => 'III-B1', 'base_salary' => 10000000, 'description' => 'KASIR (Kelas C)'],
            ['grade' => 3, 'class' => 'A', 'subclass' => 1, 'code' => 'III-A1', 'base_salary' => 9500000, 'description' => 'STAF (D-3)'],
            ['grade' => 2, 'class' => 'A', 'subclass' => 1, 'code' => 'II-A1', 'base_salary' => 8000000, 'description' => 'STAF (SMA)'],
            ['grade' => 1, 'class' => 'D', 'subclass' => 1, 'code' => 'I-D1', 'base_salary' => 6500000, 'description' => 'STAF (SMP)'],
        ];

        foreach ($data as $item) {
            SalaryGrade::firstOrCreate(['code' => $item['code']], $item);
        }
    }
}