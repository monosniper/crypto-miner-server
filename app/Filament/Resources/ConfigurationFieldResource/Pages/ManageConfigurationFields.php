<?php

namespace App\Filament\Resources\ConfigurationFieldResource\Pages;

use App\Filament\Resources\ConfigurationFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConfigurationFields extends ManageRecords
{
    protected static string $resource = ConfigurationFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
