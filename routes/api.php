<?php

use App\Http\Controllers\Api\V1\AppController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CoinController;
use App\Http\Controllers\Api\V1\ConfigurationController;
use App\Http\Controllers\Api\V1\ConvertationController;
use App\Http\Controllers\Api\V1\NftController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ReplenishmentController;
use App\Http\Controllers\Api\V1\ServerController;
use App\Http\Controllers\Api\V1\UserNftController;
use App\Http\Controllers\Api\V1\UserServerController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\TransferController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserSessionController;
use App\Http\Controllers\Api\V1\WalletController;
use App\Http\Controllers\Api\V1\WithdrawController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::domain('api.hogyx.io')->group(function () {
    Route::prefix('v1')
        ->group(function () {
            Route::post('users', [AuthController::class, 'register']);

            Route::middleware(AuthenticateOnceWithBasicAuth::class)
                ->prefix('me')
                ->group(callback: function () {
                    Route::put('/', [UserController::class, 'update']);
                    Route::post('transfer', [TransferController::class, 'store']);

                    Route::post('/send-verification-mail', [AuthController::class, 'sendVerificationMail'])
                        ->middleware('throttle:verification');

                    // Static
                    Route::get('/', [UserController::class, 'me']);
                    Route::get('ref', [UserController::class, 'ref']);
                    Route::get('session', UserSessionController::class);
                    Route::get('nfts', UserNftController::class);
                    Route::get('wallet', WalletController::class);
                    Route::get('notifications', NotificationController::class);
                    Route::get('replenishments', ReplenishmentController::class);

                    Route::apiResource('servers', UserServerController::class)
                        ->only('index', 'show');

                    Route::apiResource('withdraws', WithdrawController::class)
                        ->only('index', 'store');

                    Route::apiResource('convertations', ConvertationController::class)
                        ->only('index', 'store');

                    Route::apiResource('orders', OrderController::class)
                        ->except('destroy');
                });

            // Account
            Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
                ->middleware('throttle:3,1');
            Route::post('check-password-code', [AuthController::class, 'checkPasswordCode']);
            Route::put('update-password', [AuthController::class, 'updatePassword']);
            Route::get('verificate/{code}', [AuthController::class, 'verificateMail'])
                ->middleware('throttle:3,1');
            Route::post('check-username', [AuthController::class, 'checkUsername']);

            // Static
            Route::get('configuration', ConfigurationController::class);
            Route::get('servers', ServerController::class);
            Route::get('geo', [AppController::class, 'geo']);
            Route::get('coins', CoinController::class);
            Route::get('settings', [AppController::class, 'settings']);
            Route::get('nfts', NftController::class);
            Route::apiResource('articles', ArticleController::class)
                ->only('index', 'show');

            // WebSockets
            Route::post('check', [AuthController::class, 'checkToken']);
            Route::put('user/servers/{userServer}', [SessionController::class, 'updateUserServer']);
            Route::put('user/sessions/{session}/cache', [SessionController::class, 'cacheSession']);
            Route::apiResource('sessions', SessionController::class);
        });
    });

Route::prefix('v1')
    ->group(function () {
        Route::post('users', [AuthController::class, 'register']);

        Route::middleware([
            AuthenticateOnceWithBasicAuth::class,
        ])
            ->prefix('me')
            ->group(callback: function () {
                Route::put('/', [UserController::class, 'update']);
                Route::post('transfer', [TransferController::class, 'store']);

                Route::post('/send-verification-mail', [AuthController::class, 'sendVerificationMail'])
                    ->middleware('throttle:verification');

                // Static
                Route::get('/', [UserController::class, 'me']);
                Route::get('ref', [UserController::class, 'ref']);
                Route::get('session', UserSessionController::class);
                Route::get('nfts', UserNftController::class);
                Route::get('wallet', WalletController::class);
                Route::get('notifications', NotificationController::class);
                Route::get('replenishments', ReplenishmentController::class);

                Route::apiResource('servers', UserServerController::class)
                    ->only('index', 'show');

                Route::apiResource('withdraws', WithdrawController::class)
                    ->only('index', 'store');

                Route::apiResource('convertations', ConvertationController::class)
                    ->only('index', 'store');

                Route::apiResource('orders', OrderController::class)
                    ->except('destroy');
            });

        // Account
        Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
            ->middleware('throttle:3,1');
        Route::post('check-password-code', [AuthController::class, 'checkPasswordCode']);
        Route::put('update-password', [AuthController::class, 'updatePassword']);
        Route::get('verificate/{code}', [AuthController::class, 'verificateMail']);
        Route::post('check-username', [AuthController::class, 'checkUsername']);

        // Static
        Route::get('configuration', ConfigurationController::class);
        Route::get('servers', ServerController::class);
        Route::get('geo', [AppController::class, 'geo']);
        Route::get('coins', CoinController::class);
        Route::get('settings', [AppController::class, 'settings']);
        Route::get('nfts', NftController::class);
        Route::apiResource('articles', ArticleController::class)
            ->only('index', 'show');

        // WebSockets
        Route::post('check-token', [AuthController::class, 'checkToken']);
        Route::put('servers/{server}', [SessionController::class, 'updateUserServer']);
        Route::put('sessions/{session}/cache', [SessionController::class, 'cacheSession']);
        Route::apiResource('sessions', SessionController::class);
    });
