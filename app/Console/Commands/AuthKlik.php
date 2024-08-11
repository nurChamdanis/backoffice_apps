<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuthKlik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:klik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Authn token KLICK';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $d = createAuthKlik();
        return true;
    }
}
