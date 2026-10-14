<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClinicRoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Doctor', 'Receptionist', 'Patient', 'Admin'] as $name) {
            Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }
    }
}
