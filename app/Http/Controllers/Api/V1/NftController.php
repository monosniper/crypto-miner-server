<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NftResource;
use App\Models\Nft;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NftController extends Controller
{
    public function nfts(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $items = Nft::all();

        return NftResource::collection($items);
    }
}
