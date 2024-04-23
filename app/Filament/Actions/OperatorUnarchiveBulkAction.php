<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class OperatorUnarchiveBulkAction extends BulkAction
{
    public function __construct()
    {
        parent::__construct('from_archive');

        $this->label = 'Вытащить из архива';

        $this->action =fn (Collection $records) =>
            $records->each->update([
                'isArchive' => false
            ]);
    }
}
