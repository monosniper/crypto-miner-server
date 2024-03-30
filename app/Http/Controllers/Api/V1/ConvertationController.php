<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ConvertationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConvertationController extends Controller
{
    private ConvertationService $convertationService;

    public function __construct(ConvertationService $convertationService)
    {
        $this->convertationService = $convertationService;
    }

    public function index(): JsonResponse
    {
        $result = $this->convertationService->getAll();

        return $this->sendResponse($result);
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->convertationService->store($request->all());

        return $this->sendResponse($result);
    }
}
