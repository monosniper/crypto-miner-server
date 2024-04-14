<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\OrderResource;
use App\Models\Configuration;
use App\Models\Order;
use App\Models\Preset;

class OrderService extends CachableService
{
    protected string $resource = OrderResource::class;
    protected CacheName $cacheName = CacheName::ORDERS;
    protected CacheType $cacheType = CacheType::AUTH;

    public function store($data): OrderResource
    {
        $type = $data['type'] ?? Order::PURCHASE;
        $purchase_type = $data['purchase_type'] ?? Order::SERVER;
        $method = $data['method'] ?? Order::CRYPTO;

        switch ($type) {
            case Order::PURCHASE:
                switch ($purchase_type) {
                    case Order::SERVER:
                        if (isset($data['purchase_id'])) {
                            $preset = Preset::find($data['purchase_id']);
                            $description = __('transactions.buy_server');
                            $amount = $preset->price;
                        } else if (isset($data['configuration'])) {
                            $configuration = Configuration::create([
                                'value' => $data['configuration'],
                            ]);
                            $description = __('transactions.buy_server');
                            $amount = $configuration->price;
                        }

                        break;
                    case Order::BALANCE:
                        $description = __('transactions.replenishment');
                        $amount = $data['amount'];
                        break;
                }
                break;
            case Order::DONATE:
                $amount = $data['amount'];
                $description = __('transactions.donate');
                break;
        }

        $order = Order::create([
            'purchase_id' => $data['purchase_id'] ?? null,
            'method' => $method,
            'type' => $type,
            'purchase_type' => $purchase_type,
            'user_id' => auth()->id(),
            'amount' => $amount,
            'description' => $description,
            'configuration_id' => $configuration?->id,
        ]);

        return new OrderResource($order);
    }

    public function update($order, $data): bool
    {
        $method = $data['method'];

        if($method !== $order->method) {
            if($method === Order::CARD) {
                // TODO: Generate card checkout_url
            }
            return $order->update($data);
        }

        return false;
    }
}
