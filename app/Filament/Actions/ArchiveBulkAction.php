<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ArchiveBulkAction extends BulkAction
{
    public function __construct()
    {
        parent::__construct('to_archive');

        $this->label = 'В архив';

        $this->action = fn (Collection $records) =>
            $records->each->update([
                'isManagerArchive' => true
            ]);
    }
}
