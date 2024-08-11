<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Api\App\Http\Controllers as API;
use Modules\Api\App\Http\Controllers\Travel as TRAVEL;

Route::group([
    'prefix' => 'v2',
], function () {

    Route::post('callback-nukar', [API\CallbackController::class, 'callbackNukar']);
    Route::post('callback-klik', [API\CallbackController::class, 'callbackKlik']);

    Route::post('tester-mail', [API\UserController::class, 'testMail']);

    Route::post('term-condition', [API\UtilitasController::class, 'tnc']);
    Route::post('privacy-policy', [API\UtilitasController::class, 'policy']);
    Route::post('contact', [API\UtilitasController::class, 'contact']);

    Route::group(['middleware' => ['activity', 'checkblocked', 'cutoff']], function () { 

        Route::middleware(['activated'])->group(function () {
            Route::post('sign-in', [API\AuthController::class, 'login'])->middleware('throttle:3,5');
            Route::post('validate-pin', [API\AuthController::class, 'validasiPin']); 
        });

        Route::post('sign-up', [API\UserController::class, 'create']);
        Route::post('validate-otp', [API\AuthController::class, 'validasiOtp'])->middleware('throttle:3,5');

        Route::middleware(['sign.noauth'])->group(function () {
            Route::post('resend-otp', [API\AuthController::class, 'resendOtp'])->middleware('throttle:3,5');
            Route::post('reset-pin', [API\AuthController::class, 'resetPin'])->middleware('throttle:3,5');
            Route::post('reset-password', [API\AuthController::class, 'resetPassword'])->middleware('throttle:3,5');

            Route::middleware(['activated'])->group(function () {
                Route::post('ubah-pin', [API\AuthController::class, 'ubahPin'])->middleware('throttle:3,5');
                Route::post('ubah-password', [API\AuthController::class, 'ubahPassword'])->middleware('throttle:3,5');
            });
        });
        
        Route::middleware(['auth:api', 'activated'])->group(function () {

            Route::post('user-details', [API\UserController::class, 'index']);
            
            Route::middleware(['sign.api'])->group(function () {

                Route::post('list-menu-ppob', [API\MenuController::class, 'menuPpob']);
                Route::post('list-pulsa', [API\MenuController::class, 'getPulsa']);
                Route::post('list-produk', [API\MenuController::class, 'getPrabayar']);
                Route::post('list-kategori', [API\MenuController::class, 'listKategori']);

                Route::post('transaksi-ppob', [API\TransaksiController::class, 'createTransaction']);
                Route::post('inquiry-ppob', [API\TransaksiController::class, 'inquiry']);
                Route::post('cekId-pelanggan', [API\MenuController::class, 'inquiryIdPLN']);
                Route::post('status-transaksi', [API\TransaksiController::class, 'cekStatus']);

                Route::post('list-bank-topup', [API\TopupController::class, 'listBank']);
                Route::post('create-topup', [API\TopupController::class, 'create'])->middleware('cek.limit');
                Route::post('cek-status-topup', [API\TopupController::class, 'cekStatusDeposit']);
                Route::post('riwayat-topup', [API\TopupController::class, 'historiDeposit']);
                
                Route::post('list-bank-transfer', [API\TrfBankController::class, 'listBankTransfer']);
                Route::post('beneficiary', [API\TrfBankController::class, 'beneficiary'])->middleware('cek.limit');
                Route::post('status-beneficiary', [API\TrfBankController::class, 'statusBeneficiary']);
                Route::post('disbursement', [API\TrfBankController::class, 'disburse']);

                Route::post('beneficiary-account', [API\TrfSaldoController::class, 'beneficiary'])->middleware('cek.limit');
                Route::post('disbursement-bilpay', [API\TrfSaldoController::class, 'disburse']);
                
                Route::post('update-fcm', [API\UserController::class, 'updateFcm']);
                Route::post('update-profile', [API\UserController::class, 'updateProfile']);
                Route::post('update-phone', [API\UserController::class, 'updatePhone']);
                
                Route::post('maintenance-mode', [API\UtilitasController::class, 'maintenancemode']);
                Route::post('tukar-koin', [API\UtilitasController::class, 'tukarKoin'])->middleware('cek.limit');
                Route::post('list-banner', [API\UtilitasController::class, 'listBanner']);
                Route::post('inbox-notif', [API\UtilitasController::class, 'inboxNotif']);
                Route::post('all-settings', [API\UtilitasController::class, 'allSetting']);
                
                Route::post('mutasi-saldo', [API\TransaksiController::class, 'mutasiSaldo']);
                Route::post('histori-poin', [API\UtilitasController::class, 'historiPoin']);
                Route::post('histori-koin', [API\UtilitasController::class, 'historiKoin']);

                Route::group([
                    'prefix' => 'travel',
                ], function () {

                    Route::group([
                        'prefix' => 'train',
                    ], function () {

                        Route::post('list-station', [TRAVEL\KeretaController::class, 'listStation']);
                        Route::post('search-train', [TRAVEL\KeretaController::class, 'cariJadwal']);
                        Route::post('booking-train', [TRAVEL\KeretaController::class, 'bookingTrain']);
                        Route::post('layout-seats', [TRAVEL\KeretaController::class, 'layoutSeatTrain']);
                        Route::post('change-layout-seat', [TRAVEL\KeretaController::class, 'changeLayoutSeatTrain']);
                        Route::post('payment-train', [TRAVEL\KeretaController::class, 'paymentBookingTrain'])->middleware('cek.limit');;
                    });
                });
            });
        });
    });
});
