<?php

use Illuminate\Support\Facades\Route;
use Modules\Cron\App\Http\Controllers as CRON;

Route::group(['middleware' => ['checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {
    
        Route::get('auth-klik', [CRON\CronController::class, 'authKlik'])->name('auth.klik');
        Route::get('auth-nukar', [CRON\CronController::class, 'authNukar'])->name('auth.nukar');
        Route::get('update-prepaid', [CRON\CronController::class, 'cekHarga'])->name('update.prepaid');
        Route::get('update-postpaid', [CRON\CronController::class, 'cekHargaPasca'])->name('update.postpaid');
        Route::get('cek-akun-dorman', [CRON\CronController::class, 'cekAkunDorman'])->name('cek.dorman');
        Route::get('maintenance-on', [CRON\CronController::class, 'maintenanceOn'])->name('cutoff');
        Route::get('maintenance-off', [CRON\CronController::class, 'maintenanceOff'])->name('cuton'); 
    });
});
