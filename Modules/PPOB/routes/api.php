<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\PPOB\App\Http\Controllers as PPOB;

Route::group([
    'prefix' => 'v2',
], function () {

    Route::group(['middleware' => ['auth:api','activity', 'checkblocked']], function () {

        Route::post('pulsa', [PPOB\PPOBController::class, 'getPulsa'])->name('pulsa.list');
        
    });
    
});
