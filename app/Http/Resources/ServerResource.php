<?php

namespace App\Http\Resources;

use App\Models\ServerLog;
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
            'status' => $this->status,
            'last_work_at' => $this->last_work_at,
            'configuration' => $this->configuration->value,
            'price' => $this->configuration->price,
            'logs' => $this->whenLoaded('log', fn (ServerLog $log) => $log->logs),
            'founds' => $this->whenLoaded('log', fn (ServerLog $log) => $log->founds),
        ];
    }
}
