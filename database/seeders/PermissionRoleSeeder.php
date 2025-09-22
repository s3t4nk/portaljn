<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        // Buat permissions
        $permissions = [
            'access-hris',
            'access-finance',
            'access-engineering',
            'access-procurement',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $hrStaff = Role::firstOrCreate(['name' => 'hr_staff']);
        $financeStaff = Role::firstOrCreate(['name' => 'finance_staff']);
        $engineeringStaff = Role::firstOrCreate(['name' => 'engineering_staff']);

        // Beri izin
        $hrStaff->givePermissionTo('access-hris');
        $financeStaff->givePermissionTo('access-finance');
        $engineeringStaff->givePermissionTo('access-engineering');

        // Super admin bisa semua
        $superAdmin->givePermissionTo($permissions);
    }
}