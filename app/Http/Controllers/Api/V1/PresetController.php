<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PresetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PresetController extends Controller
{
    public function __construct(
        protected PresetService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
