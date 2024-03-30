<?php

namespace App\Services;

use App\Http\Resources\UserServerResource;
use App\Models\UserServer;
use Illuminate\Support\Facades\Cache;

class UserServerService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $servers = Cache::remember('servers.'.auth()->id(), 86400, function () {
            return auth()->user()->servers->load('server');
        });
        return UserServerResource::collection($servers);
    }

    public function getOne(string $id) {
        return Cache::remember('all.servers.'.$id, 86400, function () use($id) {
            return new UserServerResource(UserServer::find($id)->load('log'));
        });
    }
}
