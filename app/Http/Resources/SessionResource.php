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
            'servers' => ServerResource::collection($this->servers),
            'logs' => $this->logs,
            'isFirstStart' => $this->user->isFirstStart,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at,
        ];
    }
}
