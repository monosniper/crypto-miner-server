<?php

namespace App\Filament\Resources\UserServerResource\Pages;

use App\Filament\Resources\UserServerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserServer extends EditRecord
{
    protected static string $resource = UserServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
