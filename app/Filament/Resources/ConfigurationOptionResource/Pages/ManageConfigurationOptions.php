<?php

namespace App\Filament\Resources\ConfigurationOptionResource\Pages;

use App\Filament\Resources\ConfigurationOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConfigurationOptions extends ManageRecords
{
    protected static string $resource = ConfigurationOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
