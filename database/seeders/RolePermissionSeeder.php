<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'access-dashboard',
            'view-profile',
            'edit-profile',
            'view-admin-dashboard',
            'view-users-list',
            'view-user-detail',
            'approve-user',
            'reject-user',
            'manage-users',
            'manage-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions([
            'access-dashboard',
            'view-profile',
            'edit-profile',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions([
            'access-dashboard',
            'view-profile',
            'edit-profile',
            'view-admin-dashboard',
            'view-users-list',
            'view-user-detail',
        ]);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions([
            'access-dashboard',
            'view-profile',
            'edit-profile',
            'view-admin-dashboard',
            'view-users-list',
            'view-user-detail',
            'approve-user',
            'reject-user',
            'manage-users',
            'manage-roles',
        ]);
    }
}
