<?php

namespace App\Filament\Resources\ConvertationResource\Pages;

use App\Filament\Resources\ConvertationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConvertations extends ListRecords
{
    protected static string $resource = ConvertationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
