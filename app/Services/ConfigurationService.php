<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ConfigurationResource;
use App\Models\ConfigurationOption;

class ConfigurationService extends CachableService
{
    protected string $resource = ConfigurationResource::class;
    protected CacheName $cacheName = CacheName::CONFIGURATION;

    static public function calculatePrice(array $configuration): int {
        $price = 0;
        $prices = ConfigurationOption::whereIn('slug', array_filter(array_values($configuration)))->get();

        foreach ($configuration as $field) {
            $price += $prices[$field]->price;
        }

//        $price += $configuration['ip_count'] * $prices[$field]->price;
//        TODO: add count prices

        return $price;
    }
}
