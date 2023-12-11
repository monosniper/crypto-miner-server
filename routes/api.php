<?php

use App\Http\Controllers\Api\V1\AppController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CoinController;
use App\Http\Controllers\Api\V1\NftController;
use App\Http\Controllers\Api\V1\ServerController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\WithdrawController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Route;

Route::domain('api.hogyx.io')->group(function () {
    Route::prefix('v1')
        ->group(function () {
            Route::post('users', [AuthController::class, 'register']);

            Route::middleware(AuthenticateOnceWithBasicAuth::class)
                ->prefix('me')
                ->group(function () {
                    Route::get('/', [AuthController::class, 'me']);
                    Route::put('/', [AuthController::class, 'update']);

                    Route::get('wallet', [AuthController::class, 'wallet']);
                    Route::get('servers', [AuthController::class, 'servers']);
                    Route::get('servers/{id}', [AuthController::class, 'server']);

                    Route::get('coins', [CoinController::class, 'positions']);
                    Route::put('coins', [CoinController::class, 'storePositions']);

                    Route::get('notifications', [AuthController::class, 'notifications']);
                    Route::get('convertations', [AuthController::class, 'convertations']);
                    Route::get('withdraws', [AuthController::class, 'withdraws']);
                });

            Route::apiResources([
                'coins' => CoinController::class,
                'articles' => ArticleController::class,
                'servers' => ServerController::class,
                'withdraws' => WithdrawController::class,
            ]);

            Route::apiResource('sessions', SessionController::class)
                ->only('show', 'update');
            Route::post('sessions/start', [SessionController::class, 'start']);

            Route::put('user/servers', [SessionController::class, 'updateUserServer']);

            Route::get('invest', [AuthController::class, 'invest']);
            Route::post('check', [AuthController::class, 'checkToken']);

            Route::get('settings', [AppController::class, 'settings']);
            Route::get('nfts', [NftController::class, 'nfts']);
        });
    });

Route::prefix('v1')
    ->group(function () {
        Route::post('users', [AuthController::class, 'register']);

        Route::middleware(AuthenticateOnceWithBasicAuth::class)
            ->prefix('me')
            ->group(function () {
                Route::get('/', [AuthController::class, 'me']);
                Route::put('/', [AuthController::class, 'update']);

                Route::get('wallet', [AuthController::class, 'wallet']);
                Route::get('servers', [AuthController::class, 'servers']);
                Route::get('servers/{id}', [AuthController::class, 'server']);

                Route::get('coins', [CoinController::class, 'positions']);
                Route::put('coins', [CoinController::class, 'storePositions']);

                Route::get('notifications', [AuthController::class, 'notifications']);
                Route::get('convertations', [AuthController::class, 'convertations']);
                Route::get('withdraws', [AuthController::class, 'withdraws']);
            });

        Route::apiResources([
            'coins' => CoinController::class,
            'articles' => ArticleController::class,
            'servers' => ServerController::class,
            'withdraws' => WithdrawController::class,
        ]);

        Route::apiResource('sessions', SessionController::class)
            ->only('show', 'update');
        Route::post('sessions/start', [SessionController::class, 'start']);
        Route::delete('sessions/{session}/stop', [SessionController::class, 'stop']);

        Route::put('user/servers/{userServer}', [SessionController::class, 'updateUserServer']);

        Route::get('invest', [AuthController::class, 'invest']);
        Route::post('check', [AuthController::class, 'checkToken']);

        Route::get('settings', [AppController::class, 'settings']);
        Route::get('nfts', [NftController::class, 'nfts']);
    });
