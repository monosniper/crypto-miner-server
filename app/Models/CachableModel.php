<?php

namespace App\Models;

use App\Enums\CacheType;
use App\Helpers\ObjectArray;
use App\Services\CacheService;
use App\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CachableModel extends Model
{
    use Cachable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected function cache(): void
    {
        (new ObjectArray([
            [
                CacheType::DEFAULT,
                fn () => CacheService::save($this->cacheName)
            ],
            [
                CacheType::SINGLE,
                fn () => CacheService::saveFor($this->cacheName, $this->id, $this)
            ],
            [
                CacheType::AUTH,
                fn () => CacheService::saveForUser($this->cacheName, ...$this->getCacheValue())
            ],
        ]))->get($this->cacheType)();
    }

    protected static function booted(): void
    {
        static::created(fn ($model) => $model->cacheOnCreate ? $model->cache() : null);
        static::updated(fn ($model) => $model->cacheOnUpdate ? $model->cache() : null);
        static::deleted(fn ($model) => $model->cacheOnDelete ? $model->cache() : null);
    }
}
