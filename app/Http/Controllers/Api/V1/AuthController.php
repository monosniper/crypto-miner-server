<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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

    public function me(): JsonResponse
    {
        $user = Auth::user()->load('wallet');
        $resource = new UserResource($user);

        return response()->json($resource);
    }
}
