<?php
use \Modules\MarketSession\Controllers\Api\MarketSessionController as MarketSessionController;

Route::group(['prefix' => 'v2', 'middleware' => ['app_language']], function() 
{
    Route::prefix('market-session')->group(function () {
        Route::get('countdown', [MarketSessionController::class, 'countdown']);
        Route::post('attendance', [MarketSessionController::class, 'attendance']);
        Route::post('get-wheel-turn', [MarketSessionController::class, 'getLuckyWheelTurn']);
        Route::post('hot-buy', [MarketSessionController::class, 'hotBuy']);
        Route::get('get-seller/{id}', [MarketSessionController::class, 'getSeller']);
        Route::get('get-customer/{id}', [MarketSessionController::class, 'getCustomer']);
        Route::get('get-seller-product/{id}', [MarketSessionController::class, 'getSellerProducts']);
        Route::post('get-market-list', [MarketSessionController::class, 'getMarketList']);
    });
});