<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Services\QuizService;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    public function __construct(
        protected QuizService $service
    ) {}

    public function store(StoreQuizRequest $request): JsonResponse {
        $result = $this->service->store($request->validated());

        return $this->sendResponse($result);
    }
}
