<?php

namespace App\Filament\Resources\UserServerResource\Pages;

use App\Filament\Resources\UserServerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateUserServer extends CreateRecord
{
    protected static string $resource = UserServerResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $key = 'servers.'.$record->user_id;
        Cache::forget($key);
        Cache::remember($key, 86400, function () use($record) {
            return $record->user->servers;
        });
    }
}
