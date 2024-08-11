<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'transaksi-list',
            'transaksi-create',
            'transaksi-edit',
            'transaksi-delete',
            'web-setup',
            'disbursement',
            'data-arsip',
            'login-histori',
            'api-setup',
            'maintnance-mode',
            'laporan-keuangan',
            'riwayat-saldo',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name'          => $permission,
                'guard_name'    => 'admin'
            ]);
        }

    }
}
