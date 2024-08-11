<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuthNukar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:nukar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get token access nukar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $c = createAuthNukar();
        return true;
    }
}
