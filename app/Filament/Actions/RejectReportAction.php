<?php

namespace App\Filament\Actions;

use App\Enums\ReportStatus;
use App\Models\Report;
use Filament\Actions\Action;

class RejectReportAction extends Action
{
    public function __construct()
    {
        parent::__construct('reject');

        $this->label = 'Отклонить';
        $this->color = 'danger';
        $this->action = fn (Report $record) => $record->update([
            'status' => ReportStatus::REJECTED
        ]);
    }
}
