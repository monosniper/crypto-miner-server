<?php

namespace App\Filament\Manager\Resources\OperatorReportResource\Pages;

use App\Filament\Manager\Resources\OperatorReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOperatorReports extends ListRecords
{
    protected static string $resource = OperatorReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
