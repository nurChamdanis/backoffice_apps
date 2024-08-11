<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AdminController;
use Modules\Admin\App\Http\Controllers as ADM;

Auth::routes(['verify' => true]);
Route::get('/', [ADM\Auth\LoginController::class, 'loginView'])->name('loginView');
Route::group([
    'prefix'    => 'v2',
    'middleware' => ['frame', 'XSS'],
], function () {

    Route::get('email/verify/{id}/{sign}', [ADM\Auth\VerificationController::class, 'verify'])->name('verification.email');
    Route::get('verifikasi-berhasil', [ADM\Auth\VerificationController::class, 'verifySuccess'])->name('verify.success');

    Route::group([
        'prefix'    => 'main-dashboard',
        'middleware' => [
            'auth',
        ],
    ], function () {
        
        Route::patch('update-fcm', [ADM\AdminController::class, 'updateToken'])->name('fcmToken');
        
        Route::resource('income-account', ADM\IncomeController::class)->names('income');
        Route::get('income-account-list', [ADM\IncomeController::class, 'getData'])->name('income.list');
        Route::resource('escrow-account', ADM\EscrowController::class)->names('escrow');

        Route::resource('admins', ADM\OperatorController::class)->names('admins');
        Route::get('data-operator', [ADM\OperatorController::class, 'getData'])->name('admins.list');
        Route::post('data-operator-delete', [ADM\OperatorController::class, 'destroy'])->name('admins.delete');

        Route::get('edit-operator/{id}', [ADM\OperatorController::class, 'edit'])->name('admins.edit');
        Route::post('update-operator/{id}', [ADM\OperatorController::class, 'update'])->name('admins.update');

        Route::post('/reset-password', [ADM\OperatorController::class, 'resetPassword'])->name('reset.password');

        Route::resource('term-and-condition', ADM\TermController::class)->names('tnc');
        Route::resource('privacy-policy', ADM\PrivacyController::class)->names('policy');
        Route::resource('contact', ADM\KontakController::class)->names('kontak');

        Route::resource('histori-koin', ADM\HistoriKoinController::class)->names('koin');
        Route::get('histori-koin-list', [ADM\HistoriKoinController::class, 'getData'])->name('koin.list');

        Route::resource('histori-poin', ADM\HistoriPoinController::class)->names('poin');
        Route::get('histori-poin-list', [ADM\HistoriPoinController::class, 'getData'])->name('poin.list');
    });
});
