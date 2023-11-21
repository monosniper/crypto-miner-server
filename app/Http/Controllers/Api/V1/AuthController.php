<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\NftResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ServerResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'email' => 'The provided credentials do not match our records.',
            ]
        ]);
    }

    public function nfts(): JsonResponse {
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

    public function update(UpdateUserRequest $request): JsonResponse {
        $user = Auth::user();

        return response()->json(['success' => $user->update($request->validated())]);
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();
        $resource = new UserResource($user);

        return response()->json($resource);
    }

    public function wallet(): JsonResponse
    {
        $wallet = Auth::user()->wallet;
        $resource = new WalletResource($wallet);

        return response()->json($resource);
    }

    public function servers(): JsonResponse
    {
        $servers = Auth::user()->servers;
        $resource = ServerResource::collection($servers);

        return response()->json($resource);
    }

    public function server($id): JsonResponse
    {
        $server = Auth::user()->servers()->find($id);
        $resource = new ServerResource($server);

        return response()->json($resource);
    }

    public function invest(): JsonResponse
    {
        return response()->json([
            'url' => 'https://www.google.com'
        ]);
    }

    public function checkToken(Request $request) {
        return response()->json([
            'success' => true,
            'user_id' => 1
        ]);
    }

    public function notifications(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NotificationResource::collection(auth()->user()->notifications()->latest()->get());
    }
}
