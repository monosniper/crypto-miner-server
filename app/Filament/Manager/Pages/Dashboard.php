<?php

namespace App\Filament\Manager\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int | string | array
    {
        return 1;
    }
}
