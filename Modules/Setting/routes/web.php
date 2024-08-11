<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\App\Http\Controllers as SETTING;
use Modules\Setting\App\Http\Controllers\SettingController;

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {

        Route::resource('api_key', SETTING\ApiKeyController::class);
        Route::get('api-key', [SETTING\ApiKeyController::class, 'getData'])->name('api_key.list');
        Route::post('delete-api-key', [SETTING\ApiKeyController::class, 'destroy'])->name('api_key.delete');

        Route::resource('push-command', SETTING\SettingController::class);
        Route::resource('maintenance-mode', SETTING\MaintenanceController::class)->names('maintenance');
        Route::resource('setting-poin', SETTING\SetpoinController::class)->names('set.poin');
        Route::post('setting-poin-deposit', [SETTING\SetpoinController::class, 'setPoinDeposit'])->name('set.poin.dep');
        Route::post('setting-nominal-poin-deposit', [SETTING\SetpoinController::class, 'setDep'])->name('set.nom.dep');
        
        Route::post('setting-poin-referral', [SETTING\SetpoinController::class, 'setPoinReferral'])->name('set.poin.ref');
        Route::post('setting-nominal-poin-referral', [SETTING\SetpoinController::class, 'setRef'])->name('set.nom.ref');
        
        Route::resource('setting-koin', SETTING\SetkoinController::class)->names('set.koin');
        Route::post('setting-koin-updated', [SETTING\SetkoinController::class, 'setKoin'])->name('saved.koin');

        Route::resource('setting-biaya-transfer', SETTING\BiayaTransferController::class)->names('set.biaya');
        Route::post('biaya-transfer-updated', [SETTING\BiayaTransferController::class, 'setBiaya'])->name('saved.biaya');

        Route::resource('setting-produk', SETTING\SertProdukController::class)->names('set.produk');
        Route::post('setting-produk-updated', [SETTING\SertProdukController::class, 'store'])->name('saved.produk');
    });

});
