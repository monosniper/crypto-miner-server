<?php

namespace App\Filament\Actions;

use App\Enums\ReportStatus;
use App\Models\Report;
use Closure;
use Filament\Actions\Action;

class AcceptReportAction extends Action
{
    public function __construct()
    {
        parent::__construct('accept');

        $this->label = 'Принять';
        $this->color = 'success';
        $this->action = fn (Report $record) => $record->update([
            'status' => ReportStatus::ACCEPTED
        ]);
    }
}
