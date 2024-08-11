<?php

namespace Modules\Admin\Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ad = new Admin();
        $ad->name = 'Administrator';
        $ad->phone = '08112311232';
        $ad->email = 'admin@'.strtolower(str_replace(' ','',config('app.name'))).'.id';
        $ad->activated = true;
        $ad->password = Hash::make('password');
        $ad->save();

    }
}
