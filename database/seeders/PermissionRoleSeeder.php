<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        // Permissions
        Permission::create(['name' => 'create-post']);
        Permission::create(['name' => 'edit-post']);
        Permission::create(['name' => 'delete-post']);

        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->syncPermissions(['create-post', 'edit-post', 'delete-post']);
    }
}