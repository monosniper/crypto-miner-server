<?php

namespace App\Services;

use App\Enums\CacheType;
use App\Traits\Cachable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CachableService
{
    use Cachable;

    private array $types;

    public function __construct() {
        $this->types = [
            CacheType::DEFAULT->value =>
                fn ($name) => CacheService::get($name),
            CacheType::AUTH->value =>
                fn ($name) => CacheService::getAuth($name),
        ];
    }

    public function getAll(): AnonymousResourceCollection
    {
        return $this->resource::collection($this->types[$this->cacheType->value]($this->cacheName));
    }

    public function getOne(string $id = null)
    {
        return $this->resource::make(
            $id
                ? CacheService::getSingle($this->cacheName, $id)
                : CacheService::get($this->cacheName)
        );
    }
}
