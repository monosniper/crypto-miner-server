<?php

namespace App\Services;

use App\Http\Resources\ConfigurationResource;
use App\Models\ConfigurationOption;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConfigurationService
{
    public function get(): AnonymousResourceCollection
    {
        return ConfigurationResource::collection(CacheService::get(CacheService::CONFIGURATION));
    }

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
