<?php

namespace App\Filament\Resources\RefResource\Pages;

use App\Filament\Resources\RefResource;
use App\Models\Ref;
use Exception;
use Filament\Resources\Pages\CreateRecord;

class CreateRef extends CreateRecord
{
    protected static string $resource = RefResource::class;
}
