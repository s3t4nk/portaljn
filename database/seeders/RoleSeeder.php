<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'super_admin',
            'admin_hr',
            'manager',
            'staff_darat',
            'crew_laut',
            'finance_staff',
            'engineering_staff',
            'procurement_staff'
        ];

        foreach ($roles as $roleName) {
            // Gunakan where() + first(), bukan findByName()
            $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
            if (!$role) {
                Role::create(['name' => $roleName, 'guard_name' => 'web']);
            }
        }

        $this->command->info('✅ Semua role berhasil dibuat atau sudah ada.');
    }
}