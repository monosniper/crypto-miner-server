<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\WithdrawResource;
use App\Models\Withdraw;

class WithdrawService extends CachableService
{
    protected string $resource = WithdrawResource::class;
    protected CacheName $cacheName = CacheName::WITHDRAWS;
    protected CacheType $cacheType = CacheType::AUTH;

    public function store($data): WithdrawResource
    {
        $withdraw = Withdraw::create($data);

        return new WithdrawResource($withdraw);
    }
}
