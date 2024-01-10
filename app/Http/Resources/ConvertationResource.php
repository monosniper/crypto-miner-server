<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConvertationResource extends JsonResource
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
            'coin' => [
                'from' => $this->from->slug,
                'to' => $this->to->slug,
            ],
            'amount' => [
                'from' => $this->amount_from,
                'to' => $this->amount_to,
            ],
            'created_at' => $this->created_at
        ];
    }
}
