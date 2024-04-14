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
    public function __construct(
        protected OrderService $service
    ) {}

    public function index(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }

    public function show($id): JsonResponse
    {
        $result = $this->service->getOne($id);

        return $this->sendResponse($result);
    }

    public function update(Order $order, UpdateOrderRequest $request): JsonResponse
    {
        $result = $this->service->update($order, $request->validated());

        return $this->sendResponse($result);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $result = $this->service->store($request->validated());

        return $this->sendResponse($result);
    }

    public function replenishments() {
        $replenishments = Auth::user()->transactions()->replenishments()->latest()->get();
        return TransactionResource::collection($replenishments);
    }
}
