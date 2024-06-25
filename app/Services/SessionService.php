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
//        $user = auth()->user();
//
//        $user_servers = $user->servers->pluck('id')->toArray();
//        $user_servers_coins = $user->servers->each->coins->pluck('coins')->flatten()->pluck('id')->unique();
//
//        if(0 != count(array_diff($data['servers'], $user_servers))) {
//            throw new Exception('User doesn\'t have provided servers.');
//        }
//
//        if(0 != count(array_diff($data['coins'], $user_servers_coins))) {
//            throw new Exception('User servers don\'t include provided coins.');
//        }
//
//        $session = Session::create(['user_id' => $user->id]);
//        $session->coins()->sync($data['coins']);
//        $session->servers()->sync($data['servers']);
//        $servers = $session->servers;
//
//        $miner = new Miner($session);
//        $miner->start();
//
//        foreach ($servers as $server) {
//            $server->log?->delete();
//            $server->start();
//
//            for($i = 0; $i < 43200; $i+=5) {
//                $logs[] = [
//
//                ];
//            }
//        }
//
//        $this->service::saveFor(
//            $this->cacheName,
//            $session->id,
//            $session
//        );
//
//        $this->service::saveFor(
//            CacheName::USER,
//            $session->user_id,
//            single: $session->user_id,
//        );
//
//        // event(new SessionStart($session));
//
//        return new SessionResource($session);

        $user_id = $data['user_id'];

        $session = Session::create(['user_id' => $user_id]);
        $session->coins()->sync($data['coins']);
        $session->servers()->sync($data['servers']);
        $servers = $session->servers;

        foreach ($servers as $server) {
            $server->log?->delete();
            $server->start();
        }

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

    public function updateServer(Server $server, $data): true
    {
        if($server->server_log_id) {
            $log = $server->log;
            $log->update([
                'logs' => [...$log->logs, ...$data['logs']],
                'founds' => [...$log->founds, ...$data['founds']],
            ]);
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
        Cache::put('sessions.'.$session->user_id, new SessionResource($session->load('user_servers.log')));

        return ['success' => true];
    }

    public function destroy(Session $session): ?bool
    {
        return $session->delete();
    }
}
