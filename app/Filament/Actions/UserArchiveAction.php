<?php

namespace App\Filament\Actions;

use App\Models\Call;
use App\Models\User;
use Filament\Tables\Actions\Action;

class UserArchiveAction extends ArchiveAction
{
    public function __construct()
    {
        parent::__construct();

        $this->action = fn (User $user) => $user->call()->updateOrCreate([
            'isManagerArchive' => true
        ]);
    }
}
