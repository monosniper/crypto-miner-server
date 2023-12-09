<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ConvertationResource;
use App\Http\Resources\NftResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ServerResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserServerResource;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WithdrawResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): array
    {
        $user = User::create($request->validated());

        return ['success' => !!$user];
    }

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

    public function withdraws(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $withdraws = Auth::user()->withdraws;
        return WithdrawResource::collection($withdraws);
    }

    public function nfts(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $nfts = Auth::user()->nfts;

        return NftResource::collection($nfts);
    }

    public function convertations(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $convertations = Auth::user()->convertations;
        return ConvertationResource::collection($convertations);
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

    public function me(): UserResource
    {
        $user = Auth::user();

        return new UserResource($user);
    }

    public function wallet(): WalletResource
    {
        $wallet = Auth::user()->wallet;

        return new WalletResource($wallet);
    }

    public function servers(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $servers = Auth::user()->servers;

        return UserServerResource::collection($servers);
    }

    public function server($id): ServerResource
    {
        $server = Auth::user()->servers()->find($id);

        return new ServerResource($server);
    }

    public function invest(): array
    {
        return [
            'url' => 'https://www.google.com'
        ];
    }

    public function checkToken(Request $request): array
    {
        $user = User::where('token', $request->token)->first();

        return [
            'success' => (bool)$user,
            'user_id' => $user?->id
        ];
    }

    public function notifications(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NotificationResource::collection(auth()->user()->notifications()->latest()->get());
    }
}
