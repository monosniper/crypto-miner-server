<?php

namespace App\Services;

use App\Http\Resources\UserResource;

class UserService
{
    public function update($data) {
        $rs = auth()->user()->update($data);

        if($rs) CacheService::saveFor(CacheService::USER, auth()->id());

        return $rs;
    }

    public function me(): UserResource
    {
        return new UserResource(CacheService::getSingle(CacheService::USER, auth()->id()));
    }

    public function ref()
    {
        return CacheService::getSingle(CacheService::USER_REF, auth()->id());
    }
}
