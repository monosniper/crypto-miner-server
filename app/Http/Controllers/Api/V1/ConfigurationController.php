<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ConfigurationService;
use Illuminate\Http\JsonResponse;

class ConfigurationController extends Controller
{
    private ConfigurationService $configurationService;

    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function __invoke(): JsonResponse
    {
        $result = $this->configurationService->get();

        return $this->sendResponse($result);
    }
}
