<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\UserServer;
use Illuminate\Console\Command;

class UserServersInspector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-servers:inspector';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update use servers statuses if they are expired';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $servers = UserServer::where('active_until', '<', \Carbon\Carbon::now())->get();

        foreach ($servers as $server) $server->update(['status' => Server::NOT_ACTIVE_STATUS]);
    }
}
