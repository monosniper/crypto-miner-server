<?php

namespace App\Services;

use App\Enums\CacheName;
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
        return new UserResource(CacheService::getSingle(CacheName::USER, auth()->id()));
    }

    public function ref()
    {
        return CacheService::getSingle(CacheName::USER_REF, auth()->id());
    }
}
