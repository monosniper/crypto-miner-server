<?php

namespace App\Observers;

use App\Models\Configuration;
use App\Services\ConfigurationService;

class ConfigurationObserver
{
    public function created(Configuration $configuration): void
    {
        $configuration->price = ConfigurationService::calculatePrice($configuration->value);
        $configuration->save();
    }
}
