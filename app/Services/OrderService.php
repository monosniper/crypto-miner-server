<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderType;
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
        $type = $data['type'] ?? OrderType::PURCHASE;
        $purchase_type = $data['purchase_type'] ?? OrderPurchaseType::SERVER;
        $method = $data['method'] ?? OrderMethod::CRYPTO;

        switch ($type) {
            case OrderType::PURCHASE:
                switch ($purchase_type) {
                    case OrderPurchaseType::SERVER:
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
                    case OrderPurchaseType::BALANCE:
                        $description = __('transactions.replenishment');
                        $amount = $data['amount'];
                        break;
                }
                break;
            case OrderType::DONATE:
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

        if($method !== $order->method->value) {
            if($method === OrderMethod::CARD) {
                // TODO: Generate card checkout_url
            }
            return $order->update($data);
        }

        return false;
    }
}
