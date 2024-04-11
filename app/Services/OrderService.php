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
        $method = $data['method'] ?? Order::CRYPTO;

        switch ($type) {
            case Order::PURCHASE:
                switch ($purchase_type) {
                    case Order::SERVER:
                        $server = Server::find($data['purchase_id']);
                        $description = __('transactions.buy_server');
                        $amount = $server->price;
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
