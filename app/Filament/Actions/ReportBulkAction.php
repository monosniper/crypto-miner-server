<?php

namespace App\Filament\Actions;

use App\Models\Report;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ReportBulkAction extends BulkAction
{
    public function __construct()
    {
        parent::__construct('make_report');

        $this->label = 'Создать отчет';

        $this->action = function (Collection $records) {
            $report = Report::create([
                'operator_id' => auth()->id()
            ]);
            $report->calls()->sync($records);
        };
    }
}
