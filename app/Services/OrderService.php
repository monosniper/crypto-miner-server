<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Server;

class OrderService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $orders = auth()->user()->orders();
        return OrderResource::collection($orders);
    }

    public function getOne(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    public function store($data): OrderResource
    {
        if($data['type'] === Order::PURCHASE) {
            if($data['purchase_type'] === Order::SERVER) {
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
