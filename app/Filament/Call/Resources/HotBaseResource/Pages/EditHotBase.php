<?php

namespace App\Filament\Call\Resources\HotBaseResource\Pages;

use App\Filament\Call\Resources\HotBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotBase extends EditRecord
{
    protected static string $resource = HotBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
