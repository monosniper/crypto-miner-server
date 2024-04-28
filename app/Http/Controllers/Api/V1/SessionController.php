<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Models\Server;
use App\Models\Session;
use App\Services\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct(
        private readonly SessionService $service,
    ) {}

    public function store(StoreSessionRequest $request): JsonResponse
    {
        $result = $this->service->store($request->validated());

        return $this->sendResponse($result);
    }

    public function show($id): JsonResponse
    {
        $result = $this->service->getOne($id);

        return $this->sendResponse($result);
    }

    public function destroy(Session $session): JsonResponse
    {
        $result = $this->service->destroy($session);

        return $this->sendResponse($result);
    }

    public function update(Session $session, Request $request): JsonResponse
    {
        $result = $this->service->update($session, $request->validated());

        return $this->sendResponse($result);
    }

    public function updateServer(Server $server, Request $request): JsonResponse
    {
        $result = $this->service->updateServer($server, $request);

        return $this->sendResponse($result);
    }

    public function cacheSession(Session $session): JsonResponse
    {
        $result = $this->service->cacheSession($session);

        return $this->sendResponse($result);
    }
}
