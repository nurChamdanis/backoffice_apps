<?php

use Illuminate\Support\Facades\Route;
use Modules\Trash\App\Http\Controllers\TrashController;

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {

        Route::get('list-users-trash', [TrashController::class, 'getData'])->name('list.user.trash');
        Route::resource('users-trash', TrashController::class)->names('user.trash');
        Route::post('restore-user-trash/{id}', [TrashController::class, 'restore'])->name('restore.user');
    });
});
