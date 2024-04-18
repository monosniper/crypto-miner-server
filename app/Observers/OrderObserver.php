<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderService;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if($order->status === OrderStatus::COMPLETED) {
            OrderService::processOrder($order);
        }
    }
}
