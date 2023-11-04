<?php

namespace App\Filament\Resources\UserServerResource\Pages;

use App\Filament\Resources\UserServerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserServers extends ListRecords
{
    protected static string $resource = UserServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
