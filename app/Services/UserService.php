<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    private ?\Illuminate\Contracts\Auth\Authenticatable $user;

    public function __construct() {
        $this->user = auth()->user();
    }

    public function update($data) {
        return $this->user->update($data);
    }

    public function me(): UserResource
    {
        $user = auth()->user();
//        $user = User::find(auth()->id());


        return new UserResource($user);
    }
}
