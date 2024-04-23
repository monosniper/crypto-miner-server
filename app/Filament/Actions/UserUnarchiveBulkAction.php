<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class UserUnarchiveBulkAction extends UnarchiveBulkAction
{
    public function __construct()
    {
        parent::__construct();

        $this->action = function (Collection $records) {
            foreach ($records as $record) {
                $record->call()->updateOrCreate([
                    'isManagerArchive' => false
                ]);
            }
        };
    }
}
