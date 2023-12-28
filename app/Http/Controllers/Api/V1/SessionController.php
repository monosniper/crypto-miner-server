<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\SessionStart;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSessionRequest;
use App\Http\Requests\UpdateUserServerRequest;
use App\Http\Resources\SessionResource;
use App\Models\Server;
use App\Models\ServerLog;
use App\Models\Session;
use App\Models\UserServer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SessionController extends Controller
{
    public function start(Request $request): \Illuminate\Http\JsonResponse
    {
        $session = Session::create([
            'user_id' => $request->input('user_id')
        ]);

        $session->coins()->sync($request->input('coins'));
        $session->user_servers()->sync($request->input('servers'));

        $servers = $session->user_servers;

        foreach ($servers as $server) $server->update(['status' => Server::WORK_STATUS]);

        $rs = new SessionResource($session);

        Cache::add('sessions'.$request->input('user_id'), $rs);

//        event(new SessionStart($session));

        return response()->json([
            'success' => true,
            'data' => $rs
        ]);
    }

    public function updateUserServer(UserServer $userServer, UpdateUserServerRequest $request): array
    {
        $serverLog = ServerLog::create($request->validated());
        $userServer->server_log_id = $serverLog->id;
        $userServer->save();
        return ['success' => true];
    }

    public function show(Session $session): SessionResource
    {
        return new SessionResource($session->load('coins'));
    }

    public function stop(Session $session): ?bool
    {
        return $session->delete();
    }

    public function update(Session $session, UpdateSessionRequest $request): array
    {
        $logs = $session->user_servers->last()->log->logs;

        $session->update([
            ...$request->validated(),
            'end_at' => new Carbon($logs[count($logs)-1]->timestamp)
        ]);

        return ['success' => true];
    }
}
