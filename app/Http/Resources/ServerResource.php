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
            'icon_url' => $this->getIconUrl(),
            'title' => $this->title,
            'price' => $this->price,
            'year_price' => $this->year_price,
            'work_time' => $this->work_time,
            'nft' => $this->nft,
            'isHot' => $this->isHot,
            'type' => $this->type,
            'possibilities' => PossibilityResource::collection($this->possibilities),
            'coins' => CoinResource::collection($this->coins),
            'user_server_id' => $this->whenPivotLoaded('user_server_id', $this->pivot?->user_server_id),
            'active_until' => $this->whenPivotLoaded('users_servers', $this->pivot?->active_until),
            'status' => $this->whenPivotLoaded('users_servers', $this->pivot?->status),
            'server_user_name' => $this->whenPivotLoaded('users_servers', $this->pivot?->name),
            'logs' => $this->whenPivotLoaded('users_servers', $this->pivot?->logs),
        ];
    }
}
