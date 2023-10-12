<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
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
            'title' => $this->title,
            'price' => $this->price,
            'year_price' => $this->year_price,
            'nft' => $this->nft,
            'isHot' => $this->isHot,
            'work_started_at' => $this->whenPivotLoaded('users_servers', $this->pivot?->work_started_at),
            'active_until' => $this->whenPivotLoaded('users_servers', $this->pivot?->active_until),
            'status' => $this->whenPivotLoaded('users_servers', $this->pivot?->status),
        ];
    }
}
