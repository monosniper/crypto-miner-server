<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawRequest;
use App\Services\WithdrawService;
use Illuminate\Http\JsonResponse;

class WithdrawController extends Controller
{
    public function __construct(
        protected WithdrawService $service
    ) {}

    public function index(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }

    public function store(StoreWithdrawRequest $request): JsonResponse
    {
        $result = $this->service->store($request->validated());

        return $this->sendResponse($result);
    }
}
