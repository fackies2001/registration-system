<?php

namespace Database\Seeders;

use App\Enums\AccountStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed the super admin user.
     */
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@system.com'],
            [
                'full_name' => 'Super Admin',
                'organization' => 'System Administration',
                'designation' => 'Super Administrator',
                'country' => 'Philippines',
                'address' => 'System',
                'contact_number' => '0000000000',
                'email_verified_at' => now(),
                'account_status' => AccountStatus::ACTIVE,
                'approved_at' => now(),
            ],
        );

        $superAdmin->assignRole('super_admin');
    }
}
