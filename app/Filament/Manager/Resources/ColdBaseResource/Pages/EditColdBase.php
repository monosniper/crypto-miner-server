<?php

namespace App\Filament\Manager\Resources\ColdBaseResource\Pages;

use App\Filament\Manager\Resources\ColdBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditColdBase extends EditRecord
{
    protected static string $resource = ColdBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
