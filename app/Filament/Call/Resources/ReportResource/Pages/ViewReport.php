<?php

namespace App\Filament\Call\Resources\ReportResource\Pages;

use App\Filament\Actions\RecallReportAction;
use App\Filament\Call\Resources\ReportResource;
use App\Filament\Rows\ReportRaw;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(ReportRaw::make());
    }

    protected function getHeaderActions(): array
    {
        return [
            (new RecallReportAction(isTable: false))()
        ];
    }
}
