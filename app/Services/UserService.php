<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Jobs\SendVerificationMail;

class UserService
{
    public function update($data) {
        $user = auth()->user();
        $rs = $user->update($data);

        if(isset($data['email']) && $data['email'] !== $user->email) {
            SendVerificationMail::dispatch($user);
        }

        if($rs) CacheService::saveFor(CacheService::USER, $user->id);

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
