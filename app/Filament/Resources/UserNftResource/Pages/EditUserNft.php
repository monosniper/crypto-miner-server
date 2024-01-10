<?php

namespace App\Filament\Resources\UserNftResource\Pages;

use App\Filament\Resources\UserNftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserNft extends EditRecord
{
    protected static string $resource = UserNftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
