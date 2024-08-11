<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\App\Http\Controllers as USER;
use Modules\Users\App\Http\Controllers\UsersController;

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {

        Route::resource('members', USER\UsersController::class);
        Route::get('member-list', [USER\UsersController::class, 'getData'])->name('member.list');
//show enterprise user
        Route::get('user', [USER\UsersController::class, 'user'])->name('users::user');
        Route::get('member-user', [USER\UsersController::class, 'getBata'])->name('member.user');
//end enterprise

        Route::post('delete-member', [USER\UsersController::class, 'destroy'])->name('member.delete');
        Route::post('edit-member', [USER\UsersController::class, 'update'])->name('member.update');
        Route::post('import-member', [USER\UsersController::class, 'import'])->name('member.import');
        Route::post('import-member-balance', [USER\UsersController::class, 'importBalance'])->name('member.importBalance');

Route::get('/adjustSaldo/{id}', [USER\UsersController::class, 'adjustSaldo'])->name('layouts.adjustSaldo');
Route::post('updateSaldo/{id}', [USER\UsersController::class, 'updateSaldo']);
 Route::post('updateSaldo/{id}', [USER\UsersController::class, 'updateSaldo'])->name('layouts.updateSaldo');

        Route::resource('banner', USER\BannerController::class);
        Route::get('banner-list', [USER\BannerController::class, 'getData'])->name('banner.list');
        Route::post('delete-banner', [USER\BannerController::class, 'destroy'])->name('banner.delete');
        Route::post('edit-banner', [USER\BannerController::class, 'update'])->name('banner.update');

        Route::resource('pay-method', USER\PaymentMethodController::class);
        Route::get('pay-method-list', [USER\PaymentMethodController::class, 'getData'])->name('pay-method.list');
        Route::post('delete-pay-method', [USER\PaymentMethodController::class, 'destroy'])->name('pay-method.delete');
        Route::post('edit-pay-method', [USER\PaymentMethodController::class, 'update'])->name('pay-method.update');

        Route::resource('deposit', USER\DepositController::class);
        Route::get('deposit-list', [USER\DepositController::class, 'getData'])->name('deposit.list');
        Route::post('delete-deposit', [USER\DepositController::class, 'destroy'])->name('deposit.delete');
        Route::post('edit-deposit', [USER\DepositController::class, 'update'])->name('deposit.update');

        Route::post('export-members', [USER\UsersController::class, 'export'])->name('export.users');

    });
});