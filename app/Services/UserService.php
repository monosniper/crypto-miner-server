<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function update($data) {
        return auth()->user()->update($data);
    }

    public function me(): UserResource
    {
        return new UserResource(CacheService::getSingle(CacheService::USER, auth()->id()));
    }
}
