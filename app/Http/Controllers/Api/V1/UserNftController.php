<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserNftService;
use Illuminate\Http\JsonResponse;

class UserNftController extends Controller
{
    public function __construct(
        protected UserNftService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
