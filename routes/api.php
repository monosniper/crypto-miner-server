<?php

use App\Http\Controllers\Api\V1\CoinController;
use Illuminate\Support\Facades\Route;

Route::domain('api.hogyx.io')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::apiResource('coins', CoinController::class);
    });
});
