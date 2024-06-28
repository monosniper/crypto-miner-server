<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Helpers\TapApp;
use App\Http\Resources\UserResource;
use App\Jobs\SendVerificationMail;

class UserService
{
    public function __construct(
        protected CacheService $cacheService
    ) {}

    public function update($data) {
        $user = auth()->user();
        $rs = $user->update($data);

        if(isset($data['email']) && $data['email'] !== $user->email) {
            SendVerificationMail::dispatch($user);
        }

        if($rs) CacheService::saveFor(CacheName::USER, $user->id);

        return $rs;
    }

    public function me(): UserResource
    {
        TapApp::accountLink(request()->connect);
        TapApp::siteVisited();

        return new UserResource($this->cacheService->getSingle(CacheName::USER, auth()->id()));
    }

    public function ref()
    {
        return $this->cacheService->getSingle(CacheName::USER_REF, auth()->id());
    }
}
