<?php

namespace App\Filament\Resources\NftResource\Pages;

use App\Filament\Resources\NftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNft extends EditRecord
{
    protected static string $resource = NftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
