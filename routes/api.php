<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CoinController;
use App\Http\Controllers\Api\V1\ConvertationController;
use App\Http\Controllers\Api\V1\NftController;
use App\Http\Controllers\Api\V1\ServerController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\WithdrawController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Route;

Route::domain('api.hogyx.io')->group(function () {
    Route::prefix('v1')
        ->group(function () {
            Route::middleware(AuthenticateOnceWithBasicAuth::class)
                ->prefix('me')
                ->group(function () {
                    Route::get('/', [AuthController::class, 'me']);
                    Route::put('/', [AuthController::class, 'update']);

                    Route::get('wallet', [AuthController::class, 'wallet']);
                    Route::get('servers', [AuthController::class, 'servers']);

                    Route::get('nft', [NftController::class, 'nft']);
                    Route::post('nft', [NftController::class, 'withdraw_nft']);

                    Route::get('coins', [CoinController::class, 'positions']);
                    Route::put('coins', [CoinController::class, 'storePositions']);

                    Route::apiResources([
                        'convertations' => ConvertationController::class,
                        'withdraws' => WithdrawController::class,
                    ]);
                });

            Route::apiResources([
                'coins' => CoinController::class,
                'articles' => ArticleController::class,
                'servers' => ServerController::class,
            ]);

            Route::get('invest', [AuthController::class, 'invest']);
        });
    });

Route::prefix('v1')
    ->group(function () {
        Route::middleware(AuthenticateOnceWithBasicAuth::class)
            ->prefix('me')
            ->group(function () {
                Route::get('/', [AuthController::class, 'me']);
                Route::put('/', [AuthController::class, 'update']);

                Route::get('wallet', [AuthController::class, 'wallet']);
                Route::get('servers', [AuthController::class, 'servers']);
                Route::get('servers/{id}', [AuthController::class, 'server']);

                Route::get('nft', [NftController::class, 'nft']);
                Route::post('nft', [NftController::class, 'withdraw_nft']);

                Route::get('coins', [CoinController::class, 'positions']);
                Route::put('coins', [CoinController::class, 'storePositions']);

                Route::apiResources([
                    'convertations' => ConvertationController::class,
                    'withdraws' => WithdrawController::class,
                ]);
            });

        Route::apiResources([
            'coins' => CoinController::class,
            'articles' => ArticleController::class,
            'servers' => ServerController::class,
        ]);

        Route::get('invest', [AuthController::class, 'invest']);

        Route::post('check', [AuthController::class, 'checkToken']);
        Route::post('sessions/start', [SessionController::class, 'start']);
        Route::get('sessions/{session}', [SessionController::class, 'show']);
    });
