<?php

namespace App\Console;

use App\Helper\OrderHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        //結算昨日注單
        $schedule->call(function () {
            OrderHelper::generateDailySummary();
        })->daily()->at('1:00');
        //產生注單假資料
        $schedule->call(function () {
            $date = date('Y-m-d H:i:s');
            echo '$date ' . $date . "\n";
            OrderHelper::generateDailyFakeOrders($date, rand(0, 3), rand(0, 5));
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }


}
