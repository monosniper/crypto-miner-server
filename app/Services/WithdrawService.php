<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\WithdrawResource;
use App\Models\Withdraw;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WithdrawService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = WithdrawResource::class;
    protected CacheName $cacheName = CacheName::WITHDRAWS;
    protected CacheType $cacheType = CacheType::AUTH;

    public function store($data): WithdrawResource
    {
        $withdraw = Withdraw::create($data);

        return new WithdrawResource($withdraw);
    }
}
