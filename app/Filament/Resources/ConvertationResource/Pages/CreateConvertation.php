<?php

namespace App\Filament\Resources\ConvertationResource\Pages;

use App\Filament\Resources\ConvertationResource;
use App\Models\Coin;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateConvertation extends CreateRecord
{
    protected static string $resource = ConvertationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $coin_from = Coin::find($data['from_id']);
        $coin_to = Coin::find($data['to_id']);

        $data['amount_to'] = ($data['amount_from'] * $coin_from->rate) / $coin_to->rate;

        return $data;
    }

}
