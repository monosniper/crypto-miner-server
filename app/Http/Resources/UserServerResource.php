<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserServerResource extends JsonResource
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
            'active_until' => $this->active_until,
            'last_work_at' => $this->last_work_at,
            'status' => $this->status,
            'name' => $this->name,
//            'logs' => $this->whenPivotLoadedAs('log', 'server_logs', $this->log?->logs),
//            'founds' => $this->whenPivotLoadedAs('log', 'server_logs', $this->log?->founds),
//            'server' => new ServerResource($this->server),
        ];
    }
}
