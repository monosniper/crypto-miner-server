<?php

namespace App\Filament\Actions;

use App\Models\Call;
use App\Models\User;
use Closure;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ArchiveAction
{
    public string $name;
    public string $label;
    public string $type;
    public string $color = 'info';
    public string $actionType;
    public Closure $action;

    public function __construct(
        public bool $value = true,
        public bool $isCall = true,
        public bool $isOperator = false,
        public bool $isBulk = false,
    )
    {
        $this->name = $value ? 'to_archive' : 'from_archive';
        $this->type = $isOperator ? 'isArchive' : 'isManagerArchive';
        $this->label = $this->value ? 'В архив' : 'Вытащить из архива';
        $this->actionType = $this->isBulk ? BulkAction::class : Action::class;
        $data = [ $this->type => $this->value ];

        $this->action = $this->isCall
            ? ($this->isBulk
                ? fn(Collection $records) => $records->each->update($data)
                : fn(Call $record) => $record->update($data)
            )
            : ($this->isBulk
                ? function (Collection $records) use($data) {
                    foreach ($records as $record) {
                        $record->call()->updateOrCreate($data);
                    }
                }
                : fn(User $record) => $record->call()->updateOrCreate($data)
            );
    }

    public function __invoke()
    {
        return $this->actionType::make($this->name)
            ->label($this->label)
            ->color($this->color)
            ->action($this->action);
    }
}
