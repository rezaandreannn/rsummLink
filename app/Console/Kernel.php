<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // assign data pasien terdaftar
        $schedule->command('patient:assign-id-satusehat')
            ->everyFiveMinutes()
            ->timezone('Asia/Jakarta');
        // send kedatangan pasien
        $schedule->command('encounter:rajal')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00');

        // send ttv pasien
        $schedule->command('observation:send')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00');

        // send condition 
        $schedule->command('condition:send')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00');

        // update finished encouter
        $schedule->command('update:encounter')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00');
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
