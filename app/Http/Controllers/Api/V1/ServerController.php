<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Services\ServerService;
use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{
    public function __construct(
        protected ServerService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
