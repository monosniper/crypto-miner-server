<?php

namespace App\Services;

use App\Http\Resources\WithdrawResource;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;

class WithdrawService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return WithdrawResource::collection(CacheService::getAuth(CacheService::WITHDRAWS));
    }

    public function store($data): WithdrawResource
    {
        $withdraw = Withdraw::create($data);

        return new WithdrawResource($withdraw);
    }
}
