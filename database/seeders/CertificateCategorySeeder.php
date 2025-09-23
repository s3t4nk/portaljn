<?php

namespace Database\Seeders;

use App\Modules\HRIS\Models\CertificateCategory;
use Illuminate\Database\Seeder;

class CertificateCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Keselamatan', 'Medis', 'Teknis', 'Operasional', 'Spesialis'
        ];

        foreach ($categories as $name) {
            CertificateCategory::firstOrCreate(['name' => $name]);
        }
    }
}