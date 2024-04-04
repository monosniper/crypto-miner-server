<?php

namespace App\Filament\Resources\ConfigurationGroupResource\Pages;

use App\Filament\Resources\ConfigurationGroupResource;
use App\Services\CacheService;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageConfigurationGroups extends ManageRecords
{
    protected static string $resource = ConfigurationGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(fn () => CacheService::save(CacheService::CONFIGURATION)),
        ];
    }
}
