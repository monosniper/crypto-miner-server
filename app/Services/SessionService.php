<?php

namespace App\Services;

use App\DataTransferObjects\ServerLogDto;
use App\Enums\CacheName;
use App\Http\Resources\SessionResource;
use App\Models\Server;
use App\Models\ServerLog;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class SessionService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = SessionResource::class;
    protected CacheName $cacheName = CacheName::SESSION;

    /**
     * @throws Exception
     */
    public function store($data): SessionResource
    {
        $user_id = $data['user_id'];

        $session = Session::create(['user_id' => $user_id]);
        $session->coins()->sync($data['coins']);
        $session->servers()->sync($data['servers']);

//        $servers = $session->servers;
//
//        foreach ($servers as $server) {
//            $server->log?->delete();
//            $server->start();
//        }

        return new SessionResource(Session::with('servers')->find($session->id));
    }

    public function update(Session $session, $data): true
    {
//        $log = $session->servers->last()->log;

        if(isset($data['logs'])) {
            $session->update([
                "logs" => $data['logs'],
                'end_at' => new Carbon($data['logs'][(count($data['logs']) - 1)]['timestamp'])
            ]);

            $this->service::saveFor($this->cacheName, $session->id, $session);
        }

//        if($log) {
//            $logs = $log->logs;
//
//            $session->update([
//                "logs" => $data['logs'],
//                'end_at' => new Carbon($logs[count($logs)-1]->timestamp)
//            ]);
//
//            $this->service::saveFor($this->cacheName, $session->id, $session);
//        }

        return true;
    }

    public function updateServer(Server $server, $data): true
    {
        if($server->server_log_id) {
            $log = $server->log;
            if($log) {
                $log->update([
                    'logs' => [...$log->logs, ...$data['logs']],
                    'founds' => [...$log->founds, ...$data['founds']],
                ]);
            }
        } else {
            $serverLog = ServerLog::create((array) ServerLogDto::from($data));
            $server->server_log_id = $serverLog->id;
        }

        $server->save();

        $user = User::find($server->user_id);

        $this->service::saveFor($this->cacheName, $user->session->id);

        return true;
    }

    public function cacheSession(Session $session)
    {
        $this->service::saveFor(
            $this->cacheName,
            $session->id,
            $session
        );

        return ['success' => true];
    }

    public function destroy(Session $session): ?bool
    {
        return $session->delete();
    }
}
