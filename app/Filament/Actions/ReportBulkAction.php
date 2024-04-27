<?php

namespace App\Filament\Actions;

use App\Models\Report;
use Closure;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ReportBulkAction
{
    public string $name = 'make_report';
    public string $label = 'Создать отчет';
    public Closure $action;

    public function __construct()
    {
        $this->action = function (Collection $records) {
            $report = Report::create([
                'operator_id' => auth()->id()
            ]);

            $report->calls()->sync($records);
        };
    }

    public function __invoke()
    {
        return BulkAction::make($this->name)
            ->label($this->label)
            ->requiresConfirmation()
            ->action($this->action);
    }
}
