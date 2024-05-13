<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateServerLogRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Models\Server;
use App\Models\Session;
use App\Services\SessionService;
use Exception;
use Illuminate\Http\JsonResponse;

class SessionController extends Controller
{
    public function __construct(
        private readonly SessionService $service,
    ) {}

    public function store(StoreSessionRequest $request): JsonResponse
    {
        try {
            $result = $this->service->store($request->validated());
        } catch (Exception $exception) {
            return $this->sendError($exception);
        }

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

    public function update(Session $session, UpdateSessionRequest $request): JsonResponse
    {
        $result = $this->service->update($session, $request->validated());

        return $this->sendResponse($result);
    }

    public function updateServer(Server $server, UpdateServerLogRequest $request): JsonResponse
    {
        $result = $this->service->updateServer($server, $request->validated());

        return $this->sendResponse($result);
    }

    public function cacheSession(Session $session): JsonResponse
    {
        $result = $this->service->cacheSession($session);

        return $this->sendResponse($result);
    }
}
