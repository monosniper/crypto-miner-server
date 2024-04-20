<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\CacheService;
use App\Services\OrderService;

class OrderObserver
{
    public function cache(Order $order): void
    {
        CacheService::saveForUser(
            CacheName::ORDERS,
            $order->user_id,
            $order
        );
    }

    public function updated(Order $order): void
    {
        if($order->status === OrderStatus::COMPLETED) {
            OrderService::processOrder($order);
        }

        $this->cache($order);
    }

    public function created(Order $order): void
    {
        $this->cache($order);
    }

    public function deleted(Order $order): void
    {
        $this->cache($order);
    }
}
