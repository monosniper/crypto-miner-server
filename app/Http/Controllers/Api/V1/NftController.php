<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NftResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NftController extends Controller
{
    public function nft(): JsonResponse {
        $nfts = Auth::user()->nfts;
        $resource = NftResource::collection($nfts);

        return response()->json($resource);
    }

    public function withdraw_nft(): JsonResponse {
        // nft_id

        return response()->json([
            'success' => true
        ]);
    }
}
