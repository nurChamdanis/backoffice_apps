<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Setting\App\Models\Setting;

class CloseMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintnance:of';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close Maintenance Mode';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $data = array(
            'mode'  => 'off',
            'title' => ''
        );
        $val->update([
            'value' => json_encode($data)
        ]);
        
        return true;
    }
}
