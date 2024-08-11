<?php

namespace App\Console;

use App\Console\Commands\DeleteExpiredActivations;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     */
    protected $commands = [
        DeleteExpiredActivations::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('activations:clean')->daily();
        $schedule->command('auth:nukar')->everyMinute();
        $schedule->command('auth:klik')->everyMinute();
        $schedule->command('cek:harga')->everyMinute();
        $schedule->command('cek:pasca')->everySixHours();
        $schedule->command('user:cek-dorman')->dailyAt('00:01');
        $schedule->command('maintnance:on')->dailyAt('23:55');
        $schedule->command('maintnance:off')->dailyAt('00:15');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
