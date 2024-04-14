<?php

namespace App\Services;

use App\DataTransferObjects\ConvertationDto;
use App\Enums\CacheName;
use App\Http\Resources\ConvertationResource;
use App\Models\Coin;
use App\Models\Convertation;

class ConvertationService extends CachableService
{
    protected string $resource = ConvertationResource::class;
    protected CacheName $cacheName = CacheName::CONVERTATIONS;

    public function store($data): bool
    {
        $user = auth()->user();

        $wallet = $user->wallet;
        $balance = $wallet->balance;

        $coin_from_id = $data['coin_from_id'];
        $coin_to_id = $data['coin_to_id'];
        $amount = $data['amount'];

        $coin_from = Coin::find($coin_from_id);
        $coin_to = Coin::find($coin_to_id);

        // Check balance
        if ($balance[$coin_from->slug] < $amount) {
            return false;
        }

        $coef = $coin_from->rate / $coin_to->rate;
        $amount_to = $amount * $coef;

        $amount_to -= $amount_to / 100 * setting('comission_fee');

        $convertation = Convertation::create(new ConvertationDto(
            user_id: $user->id,
            from_id: $coin_from_id,
            to_id: $coin_to_id,
            amount_from: $amount,
            amount_to: $amount_to,
        ));

        $balance[$coin_from->slug] -= $amount;
        $balance[$coin_to->slug] += $amount_to;

        $wallet->balance = $balance;
        $wallet->save();

        return (bool) $convertation;
    }
}
