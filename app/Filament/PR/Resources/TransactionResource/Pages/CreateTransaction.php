<?php

namespace App\Filament\PR\Resources\TransactionResource\Pages;

use App\Filament\PR\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
