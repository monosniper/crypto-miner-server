<?php

namespace App\Filament\Actions;

use App\Models\Call;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class UserArchiveBulkAction extends ArchiveBulkAction
{
    public function __construct()
    {
        parent::__construct();

        $this->action = function (Collection $records) {
            foreach ($records as $record) {
                $record->call()->updateOrCreate([
                    'isManagerArchive' => true
                ]);
            }
        };
    }
}
