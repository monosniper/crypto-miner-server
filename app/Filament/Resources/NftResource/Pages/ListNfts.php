<?php

namespace App\Filament\Resources\NftResource\Pages;

use App\Filament\Resources\NftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNfts extends ListRecords
{
    protected static string $resource = NftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
