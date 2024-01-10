<?php

namespace App\Filament\Resources\PossibilityResource\Pages;

use App\Filament\Resources\PossibilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPossibilities extends ListRecords
{
    protected static string $resource = PossibilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
