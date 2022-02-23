<?php 
use \Modules\MarketSession\Controllers\MarketSessionController as MarketSessionController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    Route::group(['prefix' => 'market-session'], function(){
        Route::resource('/', MarketSessionController::class);
        Route::get('/', [MarketSessionController::class, 'index'])->name('market-session');
        Route::post('/bulk-product-delete', [MarketSessionController::class, 'bulk_product_delete'])->name('bulk-product-delete');
        Route::get('/destroy/{id}', [MarketSessionController::class, 'destroy'])->name('market-session.destroy');
        Route::get('/create', [MarketSessionController::class, 'create'])->name('market-session.create');
        Route::post('/store', [MarketSessionController::class, 'store'])->name('market-session.store');
        Route::get('/{id}/edit', [MarketSessionController::class, 'edit'])->name('market-session.edit');
        Route::post('/update/{id}', [MarketSessionController::class, 'update'])->name('market-session.update');
    });
});