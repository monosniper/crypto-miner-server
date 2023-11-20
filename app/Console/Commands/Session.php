<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Session extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Maintains connection with sockets for a long time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new \WebSocket\Client("ws://localhost:7331?token=hello");

        $client->send(json_encode([
            'method' => 'start'
        ]));

        while (true) {
            $this->info('test');
//            try {
//                $message = $client->receive();
//                $this->info($message);
//
////                if($message === "stopped") {
////
////                }
//            } catch (\WebSocket\ConnectionException $e) {
//                $this->error($e);
//                break;
//            }
        }

        $client->close();
    }
}
