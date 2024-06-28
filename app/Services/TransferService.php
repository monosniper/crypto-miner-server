<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\TransferResource;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransferService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = TransferResource::class;
    protected CacheName $cacheName = CacheName::TRANSFERS;
    protected CacheType $cacheType = CacheType::AUTH;

    public function store($data): true
    {
        $user = User::whereName($data['username'])->first();
        $amount = $data['amount'];
        $amount = $amount - ($amount / 100 * setting('transfer_fee'));

        Transfer::create([
            'user_id' => auth()->id(),
            'user_to' => $user->id,
            'amount' => $amount,
        ]);

        return true;
    }
}
