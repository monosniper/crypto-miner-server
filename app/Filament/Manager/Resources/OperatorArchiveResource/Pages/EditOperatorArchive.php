<?php

namespace App\Filament\Manager\Resources\OperatorArchiveResource\Pages;

use App\Filament\Manager\Resources\OperatorArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOperatorArchive extends EditRecord
{
    protected static string $resource = OperatorArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
