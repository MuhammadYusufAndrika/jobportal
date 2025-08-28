<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@lokerokutimur.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        // Create company user
        $company = User::create([
            'name' => 'PT. Contoh Perusahaan',
            'email' => 'company@lokerokutimur.com',
            'email_verified_at' => now(),
            'password' => Hash::make('company123'),
        ]);

        // Assign company role
        $company->assignRole('company');

        // Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@lokerokutimur.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
        ]);

        // Assign user role
        $user->assignRole('user');

        $this->command->info('Admin, Company, and User accounts created successfully!');
        $this->command->info('Admin: admin@lokerokutimur.com / admin123');
        $this->command->info('Company: company@lokerokutimur.com / company123');
        $this->command->info('User: user@lokerokutimur.com / user123');
    }
}
