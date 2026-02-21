<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@grandiosefoods.com']);

        $admin->forceFill([
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'phone' => '+1 443 200 0000',
            'company_name' => 'Grandiose Foods',
            'email_notifications' => true,
            'email_verified_at' => now(),
            'is_admin' => true,
        ])->save();
    }
}
