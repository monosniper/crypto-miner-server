<?php

namespace App\Filament\Actions;

use App\Enums\ReportStatus;
use App\Models\Report;
use Closure;
use Filament\Actions\Action;

class ProcessReportAction
{
    public string $name;
    public string $label;
    public string $color;
    public Closure $action;

    public function __construct(
        public bool $accept = true,
    )
    {
        $this->name = $this->accept ? 'accept' : 'reject';
        $this->label = $this->accept ? 'Принять' : 'Отклонить';
        $this->color = $this->accept ? 'success' : 'danger';

        $this->action = fn (Report $record) => $record->update([
            'status' => $this->accept ? ReportStatus::ACCEPTED : ReportStatus::REJECTED,
        ]);
    }

    public function __invoke()
    {
        return Action::make($this->name)
            ->label($this->label)
            ->color($this->color)
            ->requiresConfirmation()
            ->action($this->action);
    }
}
