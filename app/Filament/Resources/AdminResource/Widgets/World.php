<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\Widget;

class World extends Widget
{
    protected static string $view = 'filament.resources.admin-resource.widgets.world';
    protected string|int|array $columnSpan = 3;
}
