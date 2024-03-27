<?php

namespace App\Filament\Manager\Resources\ArchiveResource\Pages;

use App\Filament\Manager\Resources\ArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArchive extends EditRecord
{
    protected static string $resource = ArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
