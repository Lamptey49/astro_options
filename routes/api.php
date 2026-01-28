<?php

use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post(
    '/trades/place',
    [TradeController::class, 'placeTrade']
);
