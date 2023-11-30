<?php

namespace App\Console;

use App\Console\Commands\RatesRequest;
use App\Models\Session;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(RatesRequest::class)->daily();

        $schedule->call(function () {
            $sessions = Session::where('end_at', '<', \Carbon\Carbon::now())->get();

            foreach ($sessions as $session) $session->delete();
        })->everyTenSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
