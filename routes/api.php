<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CoinController;
use App\Http\Controllers\Api\V1\ConvertationController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Route;

Route::domain('api.hogyx.io')->group(function () {
    Route::prefix('v1')
        ->group(function () {
            Route::middleware(AuthenticateOnceWithBasicAuth::class)
                ->group(function () {
                    Route::get('me', [AuthController::class, 'me']);

                    Route::apiResource('convertations', ConvertationController::class);
                });

            Route::apiResource('coins', CoinController::class);
            Route::apiResource('articles', ArticleController::class);
        });
    });

Route::prefix('v1')
    ->group(function () {
        Route::middleware(AuthenticateOnceWithBasicAuth::class)
            ->group(function () {
                Route::get('me', [AuthController::class, 'me']);

                Route::apiResource('convertations', ConvertationController::class);
            });

        Route::apiResource('coins', CoinController::class);
        Route::apiResource('articles', ArticleController::class);
    });
