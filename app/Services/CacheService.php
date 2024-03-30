<?php

namespace App\Services;


use App\Models\Coin;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    const COINS = 'coins';

    static public function save(string $name, $value = null): bool
    {
        return Cache::put(
            $name,
            $value ?: CacheService::getDefaultValue($name)
        );
    }

    static public function getDefaultValue(string $name) {
        return [
            self::COINS => Coin::all()
        ][$name];
    }
}
