<?php

use Illuminate\Support\Facades\Route;
use Modules\PPOB\App\Http\Controllers\PPOBController;
use Modules\PPOB\App\Http\Controllers as PPOB;

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {

        Route::resource('transaksi-ppob', PPOB\TransaksiController::class)->names('trx.ppob');
        Route::get('list-transaksi-ppob', [PPOB\TransaksiController::class, 'getData'])->name('trx-ppob.list');
        Route::post('delete-transaksi', [PPOB\TransaksiController::class, 'destroy'])->name('trx-ppob.delete');
        Route::post('cek-status-ppob', [PPOB\TransaksiController::class, 'cekStatus'])->name('trx-ppob.cek');
    });
});
