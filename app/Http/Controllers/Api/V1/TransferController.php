<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferRequest;
use App\Services\TransferService;

class TransferController extends Controller
{
    private TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function store(StoreTransferRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->transferService->store($request->validated());

        return $this->sendResponse($result);
    }
}
