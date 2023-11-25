<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'coins' => CoinResource::collection($this->coins),
//            'servers' => ServerResource::collection($this->user_servers),
            'servers' => $this->servers(),
            'logs' => $this->logs,
            'founds' => $this->founds,
            'current_server' => $this->when($this->currentServer, new ServerResource($this->currentServer)),
        ];
    }
}
