<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ConfigurationResource;
use App\Models\ConfigurationField;
use App\Queries\PricesQuery;

class ConfigurationService extends CachableService
{
    protected string $resource = ConfigurationResource::class;
    protected CacheName $cacheName = CacheName::CONFIGURATION;

    static public function calculatePrice(array $configuration): int {
        $totalPrice = 0;
        $field_ids = ConfigurationField::whereIn('slug', array_keys($configuration))->pluck('id')->toArray();
        $titles = array_filter(array_values($configuration));
        $prices = array_map(fn ($i) => [$i->slug, $i->price], (new PricesQuery)($titles, $field_ids));

        foreach ($prices as $price) {
            $totalPrice += $price[1];
        }

        $counts = [
            'ip_count' => 'ipv',
            'gpu_count' => 'gpu',
        ];

        foreach ($counts as $slug => $option_slug) {
            if(isset($configuration[$slug]) && $configuration[$slug] !== '1') {
                $totalPrice += (((int) $configuration[$slug])-1) * $prices[array_search($option_slug, array_map(fn ($i) => $i[0], $prices))][1];
            }
        }

        return $totalPrice;
    }
}
