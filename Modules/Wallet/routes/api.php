<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\App\Http\Controllers as Wallet;

Route::group([
    'prefix' => 'v2',
], function () {

    Route::post('auth-b2b', [Wallet\AuthController::class, 'createTokenB2b'])->name('auth-b2b');
    Route::post('auth-b2b2c', [Wallet\AuthController::class, 'createTokenB2b2c'])->name('auth-b2b2c');

    Route::middleware(['auth:api', 'sign.api', 'activated'])->group(function () {

    });

});
