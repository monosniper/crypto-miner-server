<?php

namespace App\Filament\Resources\PhonesResource\Pages;

use App\Filament\Resources\PhonesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhones extends EditRecord
{
    protected static string $resource = PhonesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
