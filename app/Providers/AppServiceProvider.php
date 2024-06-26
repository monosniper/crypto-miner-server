<?php

namespace App\Providers;

use App\Services\CacheService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);

        RateLimiter::for('verification', function (Request $request) {
            return Limit::perMinute(1)->by($request->user()->email);
        });

        $this->app->singleton(CacheService::class);
//        $this->app->bind(Miner::class, DefaultMiner::class);
    }
}
