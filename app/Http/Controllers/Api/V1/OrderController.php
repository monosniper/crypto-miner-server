<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $result = $this->orderService->getAll();

        return $this->sendResponse($result);
    }

    public function show($id): JsonResponse
    {
        $result = $this->orderService->getOne($id);

        return $this->sendResponse($result);
    }

    public function update(Order $order, UpdateOrderRequest $request): JsonResponse
    {
        $result = $this->orderService->update($order, $request->validated());

        return $this->sendResponse($result);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $result = $this->orderService->store($request->validated());

        return $this->sendResponse($result);
    }

    public function replenishments() {
        $replenishments = Auth::user()->transactions()->replenishments()->latest()->get();
        return TransactionResource::collection($replenishments);
    }
}
