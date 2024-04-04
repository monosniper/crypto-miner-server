<?php

namespace App\Filament\Resources\ConfigurationFieldResource\Pages;

use App\Filament\Resources\ConfigurationFieldResource;
use App\Services\CacheService;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConfigurationFields extends ManageRecords
{
    protected static string $resource = ConfigurationFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(fn () => CacheService::save(CacheService::CONFIGURATION)),
        ];
    }
}
