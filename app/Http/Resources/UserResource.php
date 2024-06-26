<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'token' => $this->token,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'countryCode' => $this->country_code,
            'isVerificated' => $this->isVerificated,
            'session' => (bool) $this->session_count,
            'coin_positions' => $this->coin_positions,
            'total_deposit' => $this->finished_replenishments_sum_amount,
        ];
    }
}
