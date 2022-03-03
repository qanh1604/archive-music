<?php 
use \Modules\MarketSession\Controllers\Api\MarketSessionController as MarketSessionController;

Route::get('lucky_wheel/{id}', [MarketSessionController::class, 'luckyWheel'])->name('lucky_wheel');
Route::post('sync_wheel_turn', [MarketSessionController::class, 'syncWheelTurn'])->name('lucky_wheel.sync_wheel_turn');