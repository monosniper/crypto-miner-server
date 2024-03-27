<?php

namespace App\Filament\Manager\Resources\ColdBaseResource\Pages;

use App\Filament\Manager\Resources\ColdBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListColdBases extends ListRecords
{
    protected static string $resource = ColdBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
