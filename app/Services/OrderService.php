<?php

namespace App\Services;

use App\DataTransferObjects\OrderDto;
use App\DataTransferObjects\ServerDto;
use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Enums\OrderMethod;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Server;

class OrderService extends CachableService
{
    protected string $resource = OrderResource::class;
    protected CacheName $cacheName = CacheName::ORDERS;
    protected CacheType $cacheType = CacheType::AUTH;

    public function store($data): OrderResource
    {
        return new OrderResource(
            Order::create(OrderDto::from($data))
        );
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

    static public function processOrder(Order $order): void {
        Server::create(ServerDto::fromOrder($order));
    }
}
