<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $service
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

    public function update(Article $article): JsonResponse
    {
        $result = $this->service->update($article);

        return $this->sendResponse($result);
    }
}
