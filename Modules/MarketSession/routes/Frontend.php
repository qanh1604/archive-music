<?php 
use \Modules\MarketSession\Controllers\Api\MarketSessionController as MarketSessionController;

Route::get('lucky_wheel/{id}', [MarketSessionController::class, 'luckyWheel'])->name('lucky_wheel');