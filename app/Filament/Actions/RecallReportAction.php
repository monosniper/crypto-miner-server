<?php

namespace App\Filament\Actions;

use App\Enums\ReportStatus;
use App\Models\Report;
use Filament\Tables\Actions\Action;

class RecallReportAction extends Action
{
    public function __construct()
    {
        parent::__construct('recall');

        $this->label = 'Отозвать';
        $this->action = fn (Report $record) => $record->delete();
        $this->hidden(fn (Report $report) => $report->status === ReportStatus::ACCEPTED);
    }
}
