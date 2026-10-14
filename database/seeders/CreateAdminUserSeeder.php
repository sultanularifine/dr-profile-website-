<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Create the initial super admin only when an administrator explicitly
     * supplies credentials in the environment. No insecure default password.
     */
    public function run(): void
    {
        $email = trim((string) config('seed_admin.email'));
        $password = (string) config('seed_admin.password');
        $name = trim((string) config('seed_admin.name', 'Super Admin')) ?: 'Super Admin';

        if ($email === '' || $password === '') {
            $this->command?->warn('Super Admin was not created. Set SEED_ADMIN_EMAIL and SEED_ADMIN_PASSWORD in .env, then run db:seed again.');
            return;
        }

        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::query()->where('guard_name', 'web')->get());

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password)]
        );
        $user->assignRole($role);
    }
}
