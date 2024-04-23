<?php

namespace App\Filament\Actions;

use App\Models\Call;
use App\Models\User;
use Filament\Tables\Actions\Action;

class UserUnarchiveAction extends UnarchiveAction
{
    public function __construct()
    {
        parent::__construct();

        $this->action = fn (User $user) => $user->call()->updateOrCreate([
            'isManagerArchive' => false
        ]);
    }
}
