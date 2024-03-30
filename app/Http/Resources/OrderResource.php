<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'type' => $this->type,
            'status' => $this->status,
            'method' => $this->method,
            'amount' => $this->amount,
            'description' => $this->description,
            'purchase_type' => $this->purchase_type,
            'purchase_id' => $this->purchase_id,
            'checkout_url' => $this->checkout_url,
        ];
    }
}
