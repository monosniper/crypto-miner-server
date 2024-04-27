<?php

namespace App\Filament\Actions;

use App\Enums\ReportStatus;
use App\Models\Report;
use Closure;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class RecallReportAction
{
    public string $name = 'recall';
    public string $label = 'Отозвать';
    public string $actionType;
    public Closure $action;

    public function __construct(
        public bool $isBulk = false,
        public bool $isTable = true,
        public string $color = 'danger',
    )
    {
        $this->actionType = $this->isBulk ? BulkAction::class : ($this->isTable ? TableAction::class : Action::class);

        $this->action = $this->isBulk
            ? fn(Collection $records) => $records
                ->where('status', '!=', ReportStatus::ACCEPTED)
                ->each->delete()
            : fn(Report $record) => $record->delete();
    }

    public function __invoke()
    {
        return $this->actionType::make($this->name)
            ->label($this->label)
            ->requiresConfirmation()
            ->color($this->color)
            ->hidden(fn (Report $record) => $record->status === ReportStatus::ACCEPTED)
            ->action($this->action);
    }
}
