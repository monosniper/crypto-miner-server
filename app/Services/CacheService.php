<?php

namespace App\Services;


use App\Models\Article;
use App\Models\Coin;
use App\Models\Nft;
use App\Models\Order;
use App\Models\Server;
use App\Models\User;
use App\Models\UserServer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
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
            $value ?: CacheService::getDefaultValue($name)
        );
    }

    static public function getDefaultValue(string $name) {
        return [
            self::SERVERS => Server::all()->load(['possibilities', 'coins']),
            self::USER_SERVERS => auth()->user()->servers->load('server'),
            self::COINS => Coin::all(),
            self::NOTIFICATIONS => auth()->user()->notifications()->latest()->get(),
            self::REPLENISHMENTS => auth()->user()->replenishments(),
            self::USER_NFTS => auth()->user()->nfts(),
            self::ORDERS => auth()->user()->orders(),
            self::WALLET => auth()->user()->wallet(),
            self::SESSION => auth()->user()->session,
//            self::SESSION => auth()->user()->session()->load('log'),
            self::WITHDRAWS => auth()->user()->withdraws()->latest()->get(),
            self::CONVERTATIONS => auth()->user()->convertations()->latest()->get(),
            self::NFTS => Nft::all(),
            self::ARTICLES => Article::latest()->get(),
            self::GEO => DB::select("
                SELECT country_code, count(country_code) as total FROM users WHERE country_code IS NOT NULL
                GROUP BY country_code ORDER BY total DESC
            "),
        ][$name];
    }

    static public function getDefaultSingleValue(string $name, $id) {
        return [
            self::ARTICLES => Article::find($id),
            self::ORDERS => Order::find($id),
            self::USER_SERVERS => UserServer::find($id),
            self::USER_NFTS => Nft::find($id),
            self::USER => User::find($id),
        ][$name];
    }

    static public function get(string $name) {
        return Cache::rememberForever($name, fn () => CacheService::getDefaultValue($name));
    }

    static public function getAuth(string $name) {
        return Cache::rememberForever('user.' . auth()->id() . '.' . $name, fn () => CacheService::getDefaultValue($name));
    }

    static public function getSingle(string $name, $id) {
        return Cache::rememberForever($name . '.' . $id, fn () => CacheService::getDefaultSingleValue($name, $id));
    }
}
