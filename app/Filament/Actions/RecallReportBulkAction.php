<?php

namespace App\Filament\Actions;

use App\Enums\ReportStatus;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class RecallReportBulkAction extends BulkAction
{
    public function __construct()
    {
        parent::__construct('recall');

        $this->label = 'Отозвать';

        $this->action = fn (Collection $records) =>
            $records
                ->where('status', '!=', ReportStatus::ACCEPTED)
                ->each->delete();
    }
}
