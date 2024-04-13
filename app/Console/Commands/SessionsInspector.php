<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SessionsInspector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:inspector';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all ended sessions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sessions = Session::whereNotNull('end_at')->where('end_at', '<', Carbon::now())->get();

        foreach ($sessions as $session) if($session->end_at) $session->delete();
    }
}
