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
            'isVerificated' => $this->isVerificated,
            'coin_positions' => $this->coin_positions,
            'session' => $this->session->id,
            'ref_code' => $this->ref->code,
            'total_refs' => $this->ref->users()->count(),
            'total_refs_amount' => $this->ref->totalDonates(),
        ];
    }
}
