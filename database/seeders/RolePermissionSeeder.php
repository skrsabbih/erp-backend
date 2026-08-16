<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permission seeder
        $permissions = [
            // user permissions
            'user.view', 'user.create', 'user.update', 'user.delete',
            // role permissions
            'role.view', 'role.create', 'role.update', 'role.delete',
            // permission permissions
            'permission.view', 'permission.create', 'permission.update', 'permission.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ]
            );
        }

        // role seeder
        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // assign all permissions to super-admin role and admin role as well (sync perm issions)
        $superAdmin->syncPermissions(Permission::all());
        $admin->syncPermissions([
            'user.view', 'user.create', 'user.update',
            'role.view',
            'permission.view',
        ]);
    }
}
