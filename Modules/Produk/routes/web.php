<?php

use Illuminate\Support\Facades\Route;
use Modules\Produk\App\Http\Controllers as PRODUK;
use Modules\Produk\App\Http\Controllers\ProdukController;

Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    Route::group([
        'prefix' => 'backoffice/v2',
    ], function () {

        Route::resource('menu', PRODUK\MenuController::class);
        Route::get('menu-list', [PRODUK\MenuController::class, 'getData'])->name('menu.list');
        Route::post('delete-menu', [PRODUK\MenuController::class, 'destroy'])->name('menu.delete');
        // Route::post('edit-menu', [PRODUK\MenuController::class, 'update'])->name('menu.update');

        Route::resource('kategori', PRODUK\KategoriController::class);
        Route::get('kategori-list', [PRODUK\KategoriController::class, 'getData'])->name('kategori.list');
        Route::post('delete-kategori', [PRODUK\KategoriController::class, 'destroy'])->name('kategori.delete');
        Route::post('edit-kategori', [PRODUK\KategoriController::class, 'update'])->name('kategori.update');

        Route::resource('prabayar', PRODUK\PrabayarController::class);
        Route::get('prabayar-list', [PRODUK\PrabayarController::class, 'getData'])->name('prabayar.list');
        Route::post('delete-prabayar', [PRODUK\PrabayarController::class, 'destroy'])->name('prabayar.delete');
        Route::post('edit-prabayar', [PRODUK\PrabayarController::class, 'editMarkup'])->name('prabayar.update');
        Route::post('edit-poin-prabayar', [PRODUK\PrabayarController::class, 'editPoin'])->name('prabayar.update.poin');
        Route::post('bulk-edit-prabayar', [PRODUK\PrabayarController::class, 'editMarkupBulk'])->name('prabayar.bulk');
        Route::post('edit-detail-prabayar/{id}', [PRODUK\PrabayarController::class, 'update'])->name('update.detail.pra');

        Route::resource('pascabayar', PRODUK\PascabayarController::class);
        Route::get('pascabayar-list', [PRODUK\PascabayarController::class, 'getData'])->name('pascabayar.list');
        Route::post('delete-pascabayar', [PRODUK\PascabayarController::class, 'destroy'])->name('pascabayar.delete');
        Route::post('edit-pascabayar', [PRODUK\PascabayarController::class, 'editMarkup'])->name('pascabayar.update');
        Route::post('bulk-edit-pascabayar', [PRODUK\PascabayarController::class, 'editMarkupBulk'])->name('pascabayar.bulk');

        Route::resource('prefix', PRODUK\PrefixController::class);
        Route::get('prefix-list', [PRODUK\PrefixController::class, 'getData'])->name('prefix.list');
        Route::post('delete-prefix', [PRODUK\PrefixController::class, 'destroy'])->name('prefix.delete');
        Route::post('edit-prefix', [PRODUK\PrefixController::class, 'update'])->name('prefix.update');

    });
});
