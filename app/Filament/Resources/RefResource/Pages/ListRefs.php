<?php

namespace App\Filament\Resources\RefResource\Pages;

use App\Filament\Resources\RefResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefs extends ListRecords
{
    protected static string $resource = RefResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
