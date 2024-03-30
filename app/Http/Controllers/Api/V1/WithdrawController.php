<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawRequest;
use App\Services\WithdrawService;
use Illuminate\Http\JsonResponse;

class WithdrawController extends Controller
{
    private WithdrawService $withdrawService;

    public function __construct(WithdrawService $withdrawService)
    {
        $this->withdrawService = $withdrawService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $result = $this->withdrawService->getAll();

        return $this->sendResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request): JsonResponse
    {
        $result = $this->withdrawService->store($request->validated());

        return $this->sendResponse($result);
    }
}
