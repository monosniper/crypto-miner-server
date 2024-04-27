<?php

namespace App\Filament\Manager\Resources\OldUserResource\Pages;

use App\Filament\Manager\Resources\OldUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOldUser extends EditRecord
{
    protected static string $resource = OldUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
