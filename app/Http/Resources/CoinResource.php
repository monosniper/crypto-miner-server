<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoinResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'rate' => $this->rate,
            'hardLoad' => $this->hardLoad,
            'change' => $this->change,
//            'graph' => json_decode($this->graph),
            'graph_today' => json_decode($this->graph_today),
            'icon_url' => $this->getIconUrl(),
        ];
    }
}
