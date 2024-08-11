<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'superadmin',
            'guard_name' => 'admin'
        ]);

        $permissions = Permission::pluck('id', 'id')->all();
        $admin->syncPermissions($permissions);

        Role::create([
            'name'          => 'finance',
            'guard_name'    => 'admin'
        ]);

        Role::create([
            'name'          => 'bisnis',
            'guard_name'    => 'admin'
        ]);

        Role::create([
            'name'          => 'risk',
            'guard_name'    => 'admin'
        ]);

        Role::create([
            'name'          => 'opration',
            'guard_name'    => 'admin'
        ]);

        Role::create([
            'name'          => 'cs',
            'guard_name'    => 'admin'
        ]);

        Role::create([
            'name'          => 'product',
            'guard_name'    => 'admin'
        ]);

    }
}
