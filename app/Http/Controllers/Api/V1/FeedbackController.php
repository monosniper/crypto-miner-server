<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    public function __construct(
        protected FeedbackService $service
    ) {}

    public function store(StoreFeedbackRequest $request): JsonResponse {
        $result = $this->service->store($request->validated());

        return $this->sendResponse($result);
    }
}
