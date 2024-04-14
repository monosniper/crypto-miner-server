<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'configuration.php' => $this->configuration,
            'price' => $this->price,
            'isHot' => $this->isHot,
            'canFarmNft' => $this->canFarmNft,
            'coins' => $this->coins->pluck('slug'),
        ];
    }
}
