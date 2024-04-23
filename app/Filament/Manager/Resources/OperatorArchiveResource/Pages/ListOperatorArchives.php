<?php

namespace App\Filament\Manager\Resources\OperatorArchiveResource\Pages;

use App\Filament\Manager\Resources\OperatorArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOperatorArchives extends ListRecords
{
    protected static string $resource = OperatorArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
