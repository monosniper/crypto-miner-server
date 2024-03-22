<?php

namespace App\Filament\Resources\OperatorReportResource\Pages;

use App\Filament\Resources\OperatorReportResource;
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
