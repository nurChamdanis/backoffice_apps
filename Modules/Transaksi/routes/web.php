<?php

use Illuminate\Support\Facades\Route;
use Modules\Transaksi\App\Http\Controllers\TransaksiController;
use Modules\Transaksi\App\Http\Controllers as Transaksi;

Route::group([], function () {
    Route::resource('transaksi', TransaksiController::class)->names('transaksi');
});

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {
    Route::group([
        'prefix' => 'backoffice/v2/histories',
    ], function () {
        Route::resource('topup', Transaksi\TopupHistoryController::class)->names('topup-history');
        Route::get('topup-list', [Transaksi\TopupHistoryController::class, 'getData'])->name('topup-history.list');

        Route::resource('mutation', Transaksi\MutasiHistoryController::class)->names('mutation-history');
        Route::get('mutation-list', [Transaksi\MutasiHistoryController::class, 'getData'])->name('mutation-history.list');

        Route::post('export-data-mutasi', [Transaksi\MutasiHistoryController::class, 'export'])->name('export.mutasi');

        Route::resource('transfer-saldo', Transaksi\RiwayatTrfSaldoController::class)->names('trf.saldo');
        Route::get('transfer-saldo-list', [Transaksi\RiwayatTrfSaldoController::class, 'getData'])->name('trf.saldo.list');
    });
});
