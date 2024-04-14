<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PresetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PresetController extends Controller
{
    private PresetService $presetService;

    public function __construct(PresetService $presetService)
    {
        $this->presetService = $presetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function __invoke(): JsonResponse
    {
        $result = $this->presetService->getAll();

        return $this->sendResponse($result);
    }
}
