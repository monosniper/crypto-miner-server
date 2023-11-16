<?php

namespace App\Listeners;

use App\Contracts\Miner;
use App\Events\SessionStart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use WebSocket\BadOpcodeException;

class ProcessSession
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Miner $miner) {}

    /**
     * Handle the event.
     */
    public function handle(SessionStart $event): void
    {
        $client = new \WebSocket\Client(env('WS_URL'));

        try {
            $client->send(json_encode(['method' => 'start']));
        } catch (BadOpcodeException $e) {
            $event->session->stop();
        }

        while (true) {
            try {
                $message = $client->receive();

                if($message) {
                    $message = json_decode($message);
                    $method = $message->method;

                    if($method == 'update') {
                        $event->session->update($message->data);
                    }
                }
            } catch (\WebSocket\ConnectionException $e) {
                $event->session->stop();
                break;
            }
        }

        $client->close();
    }
}
