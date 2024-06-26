<?php

namespace App\Filament\Manager\Resources\ReportResource\Pages;

use App\Enums\ReportStatus;
use App\Filament\Actions\ProcessReportAction;
use App\Filament\Manager\Resources\ReportResource;
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
        return $this->getRecord()->status === ReportStatus::SENT ? [
            (new ProcessReportAction())(),
            (new ProcessReportAction(false))(),
        ] : [];
    }
}
