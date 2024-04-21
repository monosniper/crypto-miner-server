<?php

namespace App\Services;

use App\DataTransferObjects\OrderDto;
use App\DataTransferObjects\ServerDto;
use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Server;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class OrderService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = OrderResource::class;
    protected CacheName $cacheName = CacheName::ORDERS;
    protected CacheType $cacheType = CacheType::AUTH;

    public function store($data): OrderResource
    {
        return new OrderResource(
            Order::create((array) OrderDto::from($data))
        );
    }

    public function payed(Order $order): bool
    {
        $data = [
            'code' => config('app.payment_bot.project_code'),
            'amount' => $order->amount,
            'metadata' => [
                'order_id' => $order->id,
            ],
        ];

        Http::post(config('app.payment_bot.api_url') . '/api/v1/payment', $data);

        return true;
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

    public function markCompleted($data): bool
    {
        $order = Order::find($data['metadata']['order_id']);

        return $order->update([
            'status' => OrderStatus::COMPLETED,
        ]);
    }

    public function markRejected($data): bool
    {
        $order = Order::find($data['metadata']['order_id']);

        return $order->update([
            'status' => OrderStatus::FAILED,
        ]);
    }

    static public function processOrder(Order $order): void {
        info('$order->type: '.$order->type->value);
        info('$order->purchase_type: '.$order->purchase_type->value);
        info('$order->type == OrderType::PURCHASE: '.$order->type == OrderType::PURCHASE);
        info('$order->purchase_type == OrderPurchaseType::SERVER: '.$order->purchase_type == OrderPurchaseType::SERVER);
        switch ($order->type) {
            case OrderType::PURCHASE:
                switch ($order->purchase_type) {
                    case OrderPurchaseType::SERVER:
                        Server::create((array) ServerDto::fromOrder($order));

                        break;

                    case OrderPurchaseType::BALANCE:
                        $order->user->wallet->incrementBalance($order->amount);

                        break;
                }

                break;

            case OrderType::DONATE:
                break;
        }
    }
}
