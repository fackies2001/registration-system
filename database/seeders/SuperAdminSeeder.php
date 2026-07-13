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
                'salutation' => 'Mr.',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'sex' => 'Male',
                'nationality' => 'Filipino',
                'place_of_birth' => 'Manila',
                'date_of_birth' => '1990-01-01',
                'participant_type' => 'Admin Support (Mod - Substantive Support)',
                'ministry_agency' => 'Information and Communications Technology',
                'office_subunit' => 'System Administration',
                'organization' => 'System Administration',
                'designation' => 'Super Administrator',
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
