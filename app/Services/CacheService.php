<?php

namespace App\Services;


use App\Enums\CacheName;
use App\Jobs\SaveCache;
use App\Models\Article;
use App\Models\Coin;
use App\Models\ConfigurationGroup;
use App\Models\Nft;
use App\Models\Order;
use App\Models\Preset;
use App\Models\Ref;
use App\Models\Server;
use App\Models\User;
use App\Models\UserServer;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    static public function save(CacheName $cacheName, $value = null): void
    {
        SaveCache::dispatch([
            'name' => $cacheName->value,
            'value' => $value,
        ]);
    }

    static public function saveFor(CacheName $cacheName, $id, $value = null): void
    {
        $name = $cacheName->value;

        SaveCache::dispatch([
            'path' => $name . '.' . $id,
            'name' => $name,
            'value' => $value,
            'user' => auth()->user(),
        ]);
    }

    static public function saveForUser(CacheName $cacheName, $id, $value = null): void
    {
        $name = $cacheName->value;

        SaveCache::dispatch([
            'path' => 'user.' . $id . '.' . $name,
            'name' => $name,
            'value' => $value,
            'user' => auth()->user(),
        ]);
    }

    static public function getDefaultValue(string $name, User $user = null): Closure
    {
        if($user === null) $user = auth()->user();

        return [
            CacheName::USER->value =>
                fn () => $user->loadCount('session'),
            CacheName::COINS->value =>
                fn () => Coin::all(),
            CacheName::NFTS->value =>
                fn () => Nft::all(),
            CacheName::PRESETS->value =>
                fn () => Preset::with('coins')->get(),
            CacheName::ARTICLES->value =>
                fn () => Article::latest()->get(),
            CacheName::CONFIGURATION->value =>
                fn () => ConfigurationGroup::all(),
            CacheName::SERVERS->value =>
                fn () => Server::with('coins')->get(),
            CacheName::REPLENISHMENTS->value =>
                fn () => $user?->replenishments,
            CacheName::USER_NFTS->value =>
                fn () => $user?->nfts,
            CacheName::ORDERS->value =>
                fn () => $user?->orders,
            CacheName::WALLET->value =>
                fn () => $user?->wallet,
            CacheName::SESSION->value =>
                fn () => $user?->session->load('log'),
            CacheName::USER_SERVERS->value =>
                fn () => $user?->servers->load('server'),
            CacheName::WITHDRAWS->value =>
                fn () => $user?->withdraws()->latest()->get(),
            CacheName::CONVERTATIONS->value =>
                fn () => $user?->convertations()->latest()->get(),
            CacheName::NOTIFICATIONS->value =>
                fn () => $user?->notifications()->latest()->get(),
            CacheName::GEO->value =>
                fn () => DB::select("
                    SELECT country_code, count(country_code) as total FROM users WHERE country_code IS NOT NULL
                    GROUP BY country_code ORDER BY total DESC
                "),
        ][$name];
    }

    static public function getDefaultSingleValue(string $name, $id): Closure
    {
        return [
            CacheName::ARTICLES->value =>
                fn () => Article::find($id),
            CacheName::ORDERS->value =>
                fn () => Order::find($id),
            CacheName::USER_SERVERS->value =>
                fn () => UserServer::find($id),
            CacheName::USER_NFTS->value =>
                fn () => Nft::find($id),
            CacheName::USER->value =>
                fn () => User::find($id)->loadCount('session'),
            CacheName::USER_REF->value =>
                function () use($id) {
                    $ref = Ref::where('user_id', $id)->with(['users' => function ($query) {
                        return $query->withSum(['orders' => fn($query) => $query->completed()], 'amount');
                    }])->first();

                    return [
                        'ref_code' => $ref->code,
                        'total_refs' => $ref->users->count(),
                        'total_refs_amount' => $ref->totalDonates(),
                    ];
                },
        ][$name];
    }

    static public function get(CacheName $cacheName) {
        $value = $cacheName->value;
        return Cache::rememberForever($value, CacheService::getDefaultValue($value));
    }

    static public function getAuth(CacheName $cacheName) {
        $value = $cacheName->value;
        return Cache::rememberForever('user.' . auth()->id() . '.' . $value, CacheService::getDefaultValue($value));
    }

    static public function getSingle(CacheName $cacheName, $id) {
        $value = $cacheName->value;
        return Cache::rememberForever($value . '.' . $id, CacheService::getDefaultSingleValue($value, $id));
    }
}
