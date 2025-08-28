<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['admin', 'company', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            'manage users',
            'manage jobs',
            'manage applications',
            'create jobs',  
            'view jobs',
            'apply to jobs',
            'view applications',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $companyRole = Role::findByName('company');
        $companyRole->givePermissionTo([
            'create jobs',
            'manage jobs',
            'view applications',
        ]);

        $userRole = Role::findByName('user');
        $userRole->givePermissionTo([
            'view jobs',
            'apply to jobs',
        ]);
    }
}
