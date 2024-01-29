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
use App\Models\User;
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

        foreach ($servers as $server) {
            if($server->server_log_id) ServerLog::find($server->server_log_id)->delete();
            $server->update([
                'status' => Server::WORK_STATUS,
                'server_log_id' => null
            ]);
        }

        $user_id = $request->input('user_id');

        Cache::put('sessions.'.$user_id, new SessionResource($session));
        Cache::forget('servers.'.$user_id);
        Cache::remember('servers.'.$user_id, 86400, function () use($user_id) {
            return User::find($user_id)->servers;
        });

        $isFirstStart = $session->user->isFirstStart;

        if($isFirstStart) {
            $session->user->update([
                'isFirstStart' => false
            ]);
        }

//        event(new SessionStart($session));

        return response()->json([
            'success' => true,
            'data' => new SessionResource($session),
            'isFirstStart' => $isFirstStart
        ]);
    }

    public function updateUserServer(UserServer $userServer, Request $request): array
    {
        if($userServer->server_log_id) {
            $log = $userServer->log;
            $log->update([
                'logs' => [...$log->logs, ...$request->logs],
                'founds' => [...$log->founds, ...$request->founds],
            ]);
        } else {
            $serverLog = ServerLog::create($request->all());
            $userServer->server_log_id = $serverLog->id;
        }

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

    public function update(Session $session, Request $request): array
    {
        info("END_TIME " . json_encode($session->user_servers->last()));
        info("END_TIME " . json_encode($session->user_servers->last()->log));
        info("END_TIME " . json_encode($session->user_servers->last()->log->logs[count($session->user_servers->last()->log->logs)-1]));
        $logs = $session->user_servers->last()->log->logs;

        $session->update([
            "logs" => $request->logs,
            'end_at' => new Carbon($logs[count($logs)-1]->timestamp)
        ]);

        return ['success' => true];
    }
}
