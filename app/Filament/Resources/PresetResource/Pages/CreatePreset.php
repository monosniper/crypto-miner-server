<?php

namespace App\Filament\Resources\PresetResource\Pages;

use App\DataTransferObjects\ConfigurationDto;
use App\Filament\Resources\PresetResource;
use App\Models\Configuration;
use Filament\Resources\Pages\CreateRecord;

class CreatePreset extends CreateRecord
{
    protected static string $resource = PresetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $configuration = Configuration::create((array) ConfigurationDto::from($data));

        $data['configuration_id'] = $configuration->id;

        unset($data['configuration']);

        return $data;
    }
}
