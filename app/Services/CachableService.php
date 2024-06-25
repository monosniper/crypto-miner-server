<?php

namespace App\Services;

use App\Enums\CacheType;
use App\Traits\Cachable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CachableService
{
    use Cachable;

    private array $types;

    public function __construct(
        protected CacheService $service
    ) {
        $this->types = [
            CacheType::DEFAULT->value =>
                fn ($name) => $this->service->get($name),
            CacheType::AUTH->value =>
                fn ($name) => $this->service->getAuth($name),
        ];
    }

    public function getAll(): AnonymousResourceCollection
    {
        return $this->resource::collection($this->types[$this->cacheType->value]($this->cacheName));
    }

    public function getOne(string $id = null)
    {
        $data = $id
            ? $this->service->getSingle($this->cacheName, $id)
            : $this->service->get($this->cacheName);

        return $data ? $this->resource::make($data) : null;
    }
}
