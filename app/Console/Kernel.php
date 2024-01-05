<?php

namespace App\Console;

use App\Console\Commands\PaymentChecker;
use App\Console\Commands\RatesRequest;
use App\Console\Commands\SessionsInspector;
use App\Console\Commands\UserServersInspector;
use App\Models\Server;
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
        $schedule->command(RatesRequest::class)->hourly();
        $schedule->command(UserServersInspector::class)->daily();
        $schedule->command(SessionsInspector::class)->everyTenSeconds();
        $schedule->command(PaymentChecker::class)->hourly();
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
