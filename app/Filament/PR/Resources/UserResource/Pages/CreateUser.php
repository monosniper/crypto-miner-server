<?php

namespace App\Filament\PR\Resources\UserResource\Pages;

use App\Filament\PR\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = auth()->user()->team->id;

        return $data;
    }
}
