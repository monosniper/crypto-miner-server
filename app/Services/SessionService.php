<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\ServerStatus;
use App\Http\Resources\SessionResource;
use App\Models\Server;
use App\Models\ServerLog;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class SessionService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = SessionResource::class;
    protected CacheName $cacheName = CacheName::SESSION;

    public function store($data): SessionResource
    {
        $user_id = $data['user_id'];

        $session = Session::create(['user_id' => $user_id]);
        $session->coins()->sync($data['coins']);
        $session->servers()->sync($data['servers']);
        $servers = $session->servers;

        foreach ($servers as $server) {
            if($server->server_log_id) $server->log->delete();

            $server->update([
                'status' => ServerStatus::WORK,
                'server_log_id' => null
            ]);
        }

        $this->service::saveFor(
            $this->cacheName,
            $session->id,
            $session
        );

        // event(new SessionStart($session));

        return new SessionResource($session);
    }

    public function update(Session $session, $data): true
    {
        $logs = $session->servers->last()->log->logs;

        $session->update([
            "logs" => $data['logs'],
            'end_at' => new Carbon($logs[count($logs)-1]->timestamp)
        ]);

        Cache::put('sessions.'.$session->user->id, new SessionResource($session));

        return true;
    }

    public function updateServer(Server $server, Request $request)
    {
        if($server->server_log_id) {
            $log = $server->log;
            $log->update([
                'logs' => [...$log->logs, ...$request->logs],
                'founds' => [...$log->founds, ...$request->founds],
            ]);
        } else {
            $serverLog = ServerLog::create($request->all());
            $server->server_log_id = $serverLog->id;
        }

        $server->save();

        $user = User::find($server->user_id);
        Cache::put('sessions.'.$server->user_id, new SessionResource($user->session->load('user_servers.log')));

        return ['success' => true];
    }

    public function cacheSession(Session $session)
    {
        Cache::put('sessions.'.$session->user_id, new SessionResource($session->load('user_servers.log')));

        return ['success' => true];
    }

    public function destroy(Session $session): ?bool
    {
        return $session->delete();
    }
}
