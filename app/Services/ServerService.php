<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ServerResource;
use App\Models\Server;

class ServerService extends CachableService
{
    protected string $resource = ServerResource::class;
    protected CacheName $cacheName = CacheName::SERVERS;

    public function update(array $data, Server $server): bool {
        $configuration = $server->configuration;
        $configuration['coins'] = $data['coins'];
        $server->configuration = $configuration;

        return $server->save();
    }
}
