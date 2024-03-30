<?php

namespace App\Services;

use App\Http\Resources\NftResource;
use App\Models\Nft;
use Illuminate\Support\Facades\Cache;

class NFTService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $items = Cache::rememberForever('nfts', fn () => Nft::all());

        return NftResource::collection($items);
    }
}
