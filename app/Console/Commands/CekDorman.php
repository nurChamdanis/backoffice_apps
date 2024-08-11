<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CekDorman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:cek-dorman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek akun dorman';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastDate = date('Y-m-d', strtotime('-6 months'));
        $us = User::whereDate('updated_at', '=', $lastDate)->get();
        foreach ($us as $key => $item) {
            $item->status = 'INACTIVE';
            $item->save();
        }
    }
}
