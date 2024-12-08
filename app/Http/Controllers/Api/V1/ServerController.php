<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateServerRequest;
use App\Http\Resources\ServerResource;
use App\Models\Server;
use App\Services\ServerService;
use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{
    public function __construct(
        protected ServerService $service
    ) {}

    public function index(): JsonResponse
    {
        return $this->sendResponse('hello');
        return $this->sendResponse(ServerResource::collection(auth()->user()->servers));

//        $result = $this->service->getAll();
//
//        return $this->sendResponse($result);
    }

    public function show(int $id): JsonResponse
    {
        $result = $this->service->getOne($id);

        return $this->sendResponse($result);
    }

    public function update(UpdateServerRequest $request, Server $server): JsonResponse
    {
        $result = $this->service->update($request->validated(), $server);

        return $this->sendResponse($result);
    }
}
