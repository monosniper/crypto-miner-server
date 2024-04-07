<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Server;

class OrderService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return OrderResource::collection(CacheService::getAuth(CacheService::ORDERS));
    }

    public function getOne($id): OrderResource
    {
        return new OrderResource(CacheService::getSingle(CacheService::ORDERS, $id));
    }

    public function store($data): OrderResource
    {
        $type = $data['type'] ?? Order::PURCHASE;
        $purchase_type = $data['purchase_type'] ?? Order::SERVER;

        if($type === Order::PURCHASE) {
            if($purchase_type === Order::SERVER) {
                $server = Server::find($data['purchase_id']);
                $description = __('transactions.buy_server');
                $amount = $server->price;
            } else {
                $description = __('transactions.replenishment');
                $amount = $data['amount'];
            }
        } else {
            $amount = $data['amount'];
            $description = __('transactions.donate');
        }

        $order = Order::create([
            ...$data,
            'user_id' => auth()->id(),
            'amount' => $amount,
            'description' => $description,
            'checkout_url' => 'https://app.hogyx.io',
        ]);

        return new OrderResource($order);
    }

    public function update($order, $data): bool
    {
        return $order->update($data);
    }
}
