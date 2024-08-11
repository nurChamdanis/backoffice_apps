<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $roles = Role::all();
        foreach ($roles as $role) {
            $email = $role->name.'@bilpay.co.id';
            $this->createAdmin($faker, $email, $role);
        }
    }
    
    private function createAdmin($faker, $email, $role)
    {
        $admin = Admin::create([
            'name'      => $faker->firstName,
            'phone'     => '08123'.rand(0000000, 9999999),
            'email'     => $email,
            'activated' => true,
            'password'  => Hash::make('admin2024@'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        $admin->assignRole($role);

    }
}
