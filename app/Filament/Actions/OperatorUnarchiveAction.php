<?php

namespace App\Filament\Actions;

use App\Models\Call;
use Filament\Tables\Actions\Action;

class OperatorUnarchiveAction extends Action
{
    public function __construct()
    {
        parent::__construct('from_archive');

        $this->label = 'Вытащить из архива';

        $this->action = fn (Call $call) => $call->update([
            'isArchive' => false
        ]);
    }
}
