<?php

namespace App\Filament\Call\Resources\ColdBaseResource\Pages;

use App\Filament\Call\Resources\ColdBaseResource;
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
