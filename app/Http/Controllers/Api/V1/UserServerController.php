<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserServerService;
use Illuminate\Http\JsonResponse;

class UserServerController extends Controller
{
    public function __construct(
        protected UserServerService $service
    ) {}

    public function index(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }

    public function show(string $id): JsonResponse
    {
        $result = $this->service->getOne($id);

        return $this->sendResponse($result);
    }
}
