<?php

namespace App\Filament\Actions;

use App\Models\Call;
use Filament\Tables\Actions\Action;

class UnarchiveAction extends Action
{
    public function __construct()
    {
        parent::__construct('from_archive');

        $this->label = 'Вытащить из архива';

        $this->action = fn (Call $call) => $call->update([
            'isManagerArchive' => false
        ]);
    }
}
