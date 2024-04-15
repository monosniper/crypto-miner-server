<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ConfigurationResource;
use App\Models\Coin;
use App\Models\ConfigurationField;
use App\Queries\PricesQuery;

class ConfigurationService extends CachableService
{
    protected string $resource = ConfigurationResource::class;
    protected CacheName $cacheName = CacheName::CONFIGURATION;

    static public function calculatePrice(array $configuration): int {
        $counts = [
            'ip_count' => 'ipv',
            'gpu_count' => 'gpu',
        ];
        $exclude = [
            'coins',
            'comment',
            ...array_keys($counts)
        ];
        $totalPrice = 0;
        $field_ids = ConfigurationField::whereIn('slug', array_filter(array_keys($configuration), fn ($i) => !in_array($i, $exclude)))->pluck('id')->toArray();
        $titles = array_filter(array_values($configuration), fn ($i) => !is_array($i));
        $prices = array_map(fn ($i) => [$i->slug, $i->price], (new PricesQuery)($titles, $field_ids));

        // Default prices
        foreach ($prices as $price) {
            $totalPrice += $price[1];
        }

        // Count prices
        foreach ($counts as $slug => $option_slug) {
            if(isset($configuration[$slug]) && $configuration[$slug] !== '1') {
                $totalPrice += (((int) $configuration[$slug])-1) * $prices[array_search($option_slug, array_map(fn ($i) => $i[0], $prices))][1];
            }
        }

        // Coins prices
        $coin_price = 0;

        foreach ($configuration['coins'] as $coin_id) {
            $coin_price += setting('coin_prices')[$coin_id];
        }

        $coin_count = count($configuration['coins']);
        if($coin_count > 1) {
            $coin_price *= (1 + (0.2 * $coin_count));
        }
        $totalPrice += round($coin_price);

        return $totalPrice - 1;
    }
}
