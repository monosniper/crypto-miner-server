<?php

namespace App\Filament\Actions;

use App\Models\Call;
use Filament\Tables\Actions\Action;

class ArchiveAction extends Action
{
    public function __construct()
    {
        parent::__construct('to_archive');

        $this->label = 'В архив';

        $this->action = fn (Call $call) => $call->update([
            'isManagerArchive' => true
        ]);
    }
}
