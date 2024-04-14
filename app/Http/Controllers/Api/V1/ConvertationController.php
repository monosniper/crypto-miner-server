<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ConvertationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConvertationController extends Controller
{
    public function __construct(
        protected ConvertationService $service
    ) {}

    public function index(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->service->store($request->all());

        return $this->sendResponse($result);
    }
}
