<?php

namespace App\Services;


use App\DataTransferObjects\RefDto;
use App\Enums\CacheName;
use App\Helpers\ObjectArray;
use App\Jobs\SaveCache;
use App\Models\Article;
use App\Models\Coin;
use App\Models\ConfigurationGroup;
use App\Models\Nft;
use App\Models\Order;
use App\Models\Preset;
use App\Models\Server;
use App\Models\User;
use App\Models\UserServer;
use App\Queries\GeoQuery;
use App\Queries\RefQuery;
use Closure;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public int $ttl = 86400;

    protected function multiple(?User $user): ObjectArray
    {
        return new ObjectArray([
            [ CacheName::COINS, fn () => Coin::with('media')->get() ],
            [ CacheName::NFTS, fn () => Nft::all() ],
            [ CacheName::PRESETS, fn () => Preset::all() ],
            [ CacheName::ARTICLES, fn () => Article::latest()->get() ],
            [ CacheName::CONFIGURATION, fn () => ConfigurationGroup::all() ],
            [ CacheName::SERVERS, fn () => $user?->servers()->with('configuration')->get() ],
            [ CacheName::USER, fn () => $user->loadCount('session') ],
            [ CacheName::REPLENISHMENTS, fn () => $user?->replenishments ],
            [ CacheName::USER_NFTS, fn () => $user?->nfts ],
            [ CacheName::ORDERS, fn () => $user?->orders ],
            [ CacheName::WALLET, fn () => $user?->wallet ],
            [ CacheName::SERVERS, fn () => $user?->servers ],
            [ CacheName::SESSION, fn () => $user?->session()->with('servers.log')->first() ],
            [ CacheName::USER_SERVERS, fn () => $user?->servers()->with('server')->get() ],
            [ CacheName::WITHDRAWS, fn () => $user?->withdraws()->latest()->get() ],
            [ CacheName::CONVERTATIONS, fn () => $user?->convertations()->latest()->get() ],
            [ CacheName::NOTIFICATIONS, fn () => $user?->notifications()->latest()->get() ],
            [ CacheName::GEO, fn () => (new GeoQuery)() ],
        ]);
    }

    protected function single(int $id): ObjectArray
    {
        return new ObjectArray([
            [ CacheName::ARTICLES, fn () => Article::findOrFail($id) ],
            [ CacheName::ORDERS, fn () => Order::findOrFail($id) ],
            [ CacheName::USER_SERVERS, fn () => UserServer::findOrFail($id) ],
            [ CacheName::USER_NFTS, fn () => Nft::findOrFail($id) ],
            [ CacheName::SERVERS, fn () => Server::with('configuration', 'log')->findOrFail($id) ],
            [ CacheName::USER, fn () => User::withCount('session')->withSum('replenishments', 'amount')->findOrFail($id) ],
            [ CacheName::USER_REF, fn () => RefDto::from((new RefQuery)($id)) ],
        ]);
    }

    public function getDefaultValue(CacheName $name, User $user = null): Closure
    {
        return $this->multiple($user ?? auth()->user())->get($name);
    }

    public function getDefaultSingleValue(CacheName $name, $id): Closure
    {
        return $this->single($id)->get($name);
    }

    static public function save(CacheName $cacheName, $value = null): void
    {
        SaveCache::dispatch([
            'name' => $cacheName,
            'value' => $value,
        ]);
    }

    static public function saveFor(CacheName $cacheName, $id, $value = null, $single = false): void
    {
        SaveCache::dispatch([
            'path' => $cacheName->value . '.' . $id,
            'name' => $cacheName,
            'value' => $value,
            'user' => auth()->user(),
            'single' => $single,
        ]);
    }

    static public function forgetFor(CacheName $cacheName, $id, $value = null): void
    {
        SaveCache::dispatch([
            'path' => $cacheName->value . '.' . $id,
            'name' => $cacheName,
            'value' => $value,
            'user' => auth()->user(),
            'delete' => true
        ]);
    }

    static public function saveForUser(CacheName $cacheName, $id, $value = null, $record_id = null): void
    {
        SaveCache::dispatch([
            'path' => 'user.' . $id . '.' . $cacheName->value . ($record_id ? ('.' . $record_id) : ''),
            'name' => $cacheName,
            'value' => $value,
            'user' => auth()->user(),
        ]);
    }

    public function get(CacheName $cacheName) {
        return Cache::remember(
            $cacheName->value,
            $this->ttl,
            $this->getDefaultValue($cacheName)
        );
    }

    public function getAuth(CacheName $cacheName) {
        return Cache::remember(
            'user.' . auth()->id() . '.' . $cacheName->value,
            $this->ttl,
            $this->getDefaultValue($cacheName)
        );
    }

    public function getSingle(CacheName $cacheName, $id) {
        return Cache::remember(
            $cacheName->value . '.' . $id,
            $this->ttl,
            $this->getDefaultSingleValue($cacheName, $id),
        );
    }
}
