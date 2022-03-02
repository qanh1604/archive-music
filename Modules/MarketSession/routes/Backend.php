<?php 
use \Modules\MarketSession\Controllers\MarketSessionController as MarketSessionController;
use \Modules\MarketSession\Controllers\HotOrderController as HotOrderController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    Route::group(['prefix' => 'market-session'], function(){
        Route::resource('/', MarketSessionController::class);
        Route::get('/', [MarketSessionController::class, 'index'])->name('market-session');
        Route::post('/bulk-product-delete', [MarketSessionController::class, 'bulk_product_delete'])->name('market-session.bulk-product-delete');
        Route::get('/destroy/{id}', [MarketSessionController::class, 'destroy'])->name('market-session.destroy');
        Route::get('/create', [MarketSessionController::class, 'create'])->name('market-session.create');
        Route::post('/store', [MarketSessionController::class, 'store'])->name('market-session.store');
        Route::get('/{id}/edit', [MarketSessionController::class, 'edit'])->name('market-session.edit');
        Route::get('/{id}/gift', [MarketSessionController::class, 'gift'])->name('market-session.add-gift');
        Route::get('/{id}/add_gift', [MarketSessionController::class, 'getConfigGift'])->name('market-session.get-add-gift-market');
        Route::post('/add_gift', [MarketSessionController::class, 'postConfigGift'])->name('market-session.post-add-gift-market');
        Route::post('/update/{id}', [MarketSessionController::class, 'update'])->name('market-session.update');
        Route::get('/update_key', [MarketSessionController::class, 'getSettingZoomApi'])->name('market-session.update_key_get');
        Route::post('/update_video', [MarketSessionController::class, 'updateVideo'])->name('market-session.update_video');
    });

    Route::group(['prefix' => 'hot-order'], function(){
        Route::resource('/', HotOrderController::class);
        Route::get('/', [HotOrderController::class, 'index'])->name('hot-order');
        Route::get('/{id}/edit', [HotOrderController::class, 'edit'])->name('hot-order.edit');
        Route::post('/bulk-product-delete', [HotOrderController::class, 'bulk_product_delete'])->name('hot-order.bulk-order-delete');
        Route::get('/destroy/{id}', [HotOrderController::class, 'destroy'])->name('hot-order.destroy');
        Route::get('/product_variant/{id}', [HotOrderController::class, 'getProductVariant'])->name('hot-order.product_variant');
        Route::post('/add_product', [HotOrderController::class, 'addProduct'])->name('hot-order.add_product');
        Route::post('/update_delivery_status', [HotOrderController::class, 'update_delivery_status'])->name('hot-order.update_delivery_status');
        Route::post('/update_payment_status', [HotOrderController::class, 'update_payment_status'])->name('hot-order.update_payment_status');
        Route::post('/update_tracking_code', [HotOrderController::class, 'update_tracking_code'])->name('hot-order.update_tracking_code');
    });
});