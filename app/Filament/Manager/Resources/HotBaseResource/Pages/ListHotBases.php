<?php

namespace App\Filament\Manager\Resources\HotBaseResource\Pages;

use App\Filament\Manager\Resources\HotBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotBases extends ListRecords
{
    protected static string $resource = HotBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
