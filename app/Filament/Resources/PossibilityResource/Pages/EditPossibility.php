<?php

namespace App\Filament\Resources\PossibilityResource\Pages;

use App\Filament\Resources\PossibilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPossibility extends EditRecord
{
    protected static string $resource = PossibilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
