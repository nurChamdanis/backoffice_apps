<?php

use Illuminate\Support\Facades\Route;
use Modules\InstTransfer\App\Http\Controllers as INSTRF;

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {

        Route::resource('instan-transfer', INSTRF\InstTransferController::class)->names('inst.trf');
        Route::get('list-instan-transfer', [INSTRF\InstTransferController::class, 'getData'])->name('inst.trf.list');
        Route::post('delete-instan-transfer', [INSTRF\InstTransferController::class, 'destroy'])->name('inst.trf.delete');
        Route::post('cek-status-instan-transfer', [INSTRF\InstTransferController::class, 'cekStatus'])->name('inst.trf.cek');
    });
});
