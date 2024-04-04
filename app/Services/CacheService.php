<?php

namespace App\Services;


use App\Models\Article;
use App\Models\Coin;
use App\Models\ConfigurationGroup;
use App\Models\Nft;
use App\Models\Order;
use App\Models\Server;
use App\Models\User;
use App\Models\UserServer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    const CONFIGURATION = 'configuration';
    const SESSION = 'session';
    const USER = 'user';
    const WALLET = 'wallet';
    const NOTIFICATIONS = 'notifications';
    const REPLENISHMENTS = 'replenishments';
    const USER_NFTS = 'user_nfts';
    const USER_SERVERS = 'user_servers';
    const WITHDRAWS = 'withdraws';
    const CONVERTATIONS = 'convertations';
    const ORDERS = 'orders';
    const SERVERS = 'servers';
    const COINS = 'coins';
    const GEO = 'geo';
    const NFTS = 'nfts';
    const ARTICLES = 'articles';

    static public function save(string $name, $value = null): bool
    {
        Cache::forget($name);
        return Cache::put(
            $name,
            $value ?: CacheService::getDefaultValue($name)()
        );
    }

    static public function saveFor(string $name, $id, $value = null): bool
    {
        Cache::forget($name);
        return Cache::put(
            $name . '.' . $id,
            $value ?: CacheService::getDefaultValue($name)()
        );
    }

    static public function saveForUser(string $name, $id, $value = null): bool
    {
        Cache::forget($name);
        return Cache::put(
            'user.' . $id . '.' . $name,
            $value ?: CacheService::getDefaultValue($name)()
        );
    }

    static public function getDefaultValue(string $name): \Closure
    {
        $user = auth()->user();

        return [
            self::COINS =>
                fn () => Coin::all(),
            self::NFTS =>
                fn () => Nft::all(),
            self::ARTICLES =>
                fn () => Article::latest()->get(),
            self::CONFIGURATION =>
                fn () => ConfigurationGroup::all(),
            self::SERVERS =>
                fn () => Server::all()->load(['possibilities', 'coins']),
            self::REPLENISHMENTS =>
                fn () => $user?->replenishments,
            self::USER_NFTS =>
                fn () => $user?->nfts,
            self::ORDERS =>
                fn () => $user?->orders,
            self::WALLET =>
                fn () => $user?->wallet,
            self::SESSION =>
                fn () => $user?->session->load('log'),
            self::USER_SERVERS =>
                fn () => $user?->servers->load('server'),
            self::WITHDRAWS =>
                fn () => $user?->withdraws()->latest()->get(),
            self::CONVERTATIONS =>
                fn () => $user?->convertations()->latest()->get(),
            self::NOTIFICATIONS =>
                fn () => $user?->notifications()->latest()->get(),
            self::GEO =>
                fn () => DB::select("
                    SELECT country_code, count(country_code) as total FROM users WHERE country_code IS NOT NULL
                    GROUP BY country_code ORDER BY total DESC
                "),
        ][$name];
    }

    static public function getDefaultSingleValue(string $name, $id): \Closure
    {
        return [
            self::ARTICLES =>
                fn () => Article::find($id),
            self::ORDERS =>
                fn () => Order::find($id),
            self::USER_SERVERS =>
                fn () => UserServer::find($id),
            self::USER_NFTS =>
                fn () => Nft::find($id),
            self::USER =>
                fn () => User::find($id),
        ][$name];
    }

    static public function get(string $name) {
        return Cache::rememberForever($name, CacheService::getDefaultValue($name));
    }

    static public function getAuth(string $name) {
        return Cache::rememberForever('user.' . auth()->id() . '.' . $name, CacheService::getDefaultValue($name));
    }

    static public function getSingle(string $name, $id) {
        return Cache::rememberForever($name . '.' . $id, CacheService::getDefaultSingleValue($name, $id));
    }
}
