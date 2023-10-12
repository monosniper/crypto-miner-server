<?php

namespace App\Filament\Resources\RefResource\Pages;

use App\Filament\Resources\RefResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRef extends EditRecord
{
    protected static string $resource = RefResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
