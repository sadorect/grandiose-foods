<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Operations Manager',
                'email' => 'ops@grandiosefoods.com',
                'phone' => '+1 443 200 1001',
                'company_name' => 'Grandiose Foods',
                'email_notifications' => true,
            ],
            [
                'name' => 'Retail Buyer',
                'email' => 'buyer@sunrise-market.com',
                'phone' => '+1 443 200 1002',
                'company_name' => 'Sunrise Market',
                'email_notifications' => true,
            ],
            [
                'name' => 'Wholesale Client',
                'email' => 'client@eastcoast-wholesale.com',
                'phone' => '+1 443 200 1003',
                'company_name' => 'East Coast Wholesale',
                'email_notifications' => false,
            ],
            [
                'name' => 'Catalog Reviewer',
                'email' => 'reviewer@northtrading.io',
                'phone' => '+1 443 200 1004',
                'company_name' => 'North Trading',
                'email_notifications' => true,
            ],
            [
                'name' => 'Procurement Lead',
                'email' => 'procurement@harborfoods.co',
                'phone' => '+1 443 200 1005',
                'company_name' => 'Harbor Foods',
                'email_notifications' => false,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    ...$user,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }
    User::factory()->count(50)->create();
    }
}
