<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigurationResource;
use App\Models\ConfigurationGroup;
use App\Services\ConfigurationService;
use Illuminate\Http\JsonResponse;

class ConfigurationController extends Controller
{
    public function __construct(
        protected ConfigurationService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
