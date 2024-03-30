<?php

namespace App\Services;

use App\Http\Resources\ServerResource;
use App\Models\Server;

class ServerService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $servers = Server::all()->load(['possibilities', 'coins']);

        return ServerResource::collection($servers);
    }

    public function getOne(Server $server): ServerResource
    {
        return new ServerResource($server);
    }
}
