<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\App\Models\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $s = new Setting();
        $s->key = 'maintnance_mode';
        $s->value = '{"mode":"off","title":"Sedang Dalam Perbaikan"}';
        $s->save();
    }
}
