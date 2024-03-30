<?php

namespace App\Services;

use App\Http\Resources\WithdrawResource;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;

class WithdrawService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $withdraws = Auth::user()->withdraws()->latest()->get();
        return WithdrawResource::collection($withdraws);
    }

    public function store($data): WithdrawResource
    {
        $withdraw = Withdraw::create($data);

        return new WithdrawResource($withdraw);
    }
}
