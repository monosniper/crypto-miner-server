<?php

namespace App\Filament\Manager\Resources\OperatorReportResource\Pages;

use App\Filament\Manager\Resources\OperatorReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOperatorReport extends EditRecord
{
    protected static string $resource = OperatorReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
