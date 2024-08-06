<?php

namespace App\Console;

use Log;
use App\Models\ScheduleLog;
use Illuminate\Support\Facades\DB;
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
            ->everyFifteenMinutes()
            ->timezone('Asia/Jakarta')
            ->onSuccess(function () {
                // Simpan waktu eksekusi terakhir ke database
                ScheduleLog::updateOrInsert(
                    [
                        'command_name' => 'patient:assign-id-satusehat',
                    ],
                    [
                        'last_run_at' => now(),
                        'description' => 'post data pasien ke satu sehat menggunakan nik'
                    ]
                );
            });
        // send kedatangan pasien
        $schedule->command('encounter:rajal')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00')
            ->onSuccess(function () {
                // Simpan waktu eksekusi terakhir ke database
                ScheduleLog::updateOrInsert(
                    ['command_name' => 'encounter:rajal'],
                    [
                        'last_run_at' => now(),
                        'description' => 'post data kunjungan pasien yang telah datang'
                    ]
                );
            });

        // send ttv pasien
        $schedule->command('observation:send')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00')
            ->onSuccess(function () {
                // Simpan waktu eksekusi terakhir ke database
                ScheduleLog::updateOrInsert(
                    ['command_name' => 'observation:send'],
                    [
                        'last_run_at' => now(),
                        'description' => 'post data TTV nadi pasien yang telah di assesmen oleh perawat'
                    ]
                );
            });

        // send condition 
        $schedule->command('condition:send')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00')
            ->onSuccess(function () {
                // Simpan waktu eksekusi terakhir ke database
                ScheduleLog::updateOrInsert(
                    ['command_name' => 'condition:send'],
                    [
                        'last_run_at' => now(),
                        'description' => 'post data condition atau diagnosa yang telah diinput oleh petugas RM'
                    ]
                );
            });
        // update finished encouter
        $schedule->command('update:encounter')
            ->hourly()
            ->timezone('Asia/Jakarta')
            ->between('8:00', '20:00')
            ->after(function () {
                // Simpan waktu eksekusi terakhir ke database
                ScheduleLog::updateOrInsert(
                    ['command_name' => 'update:encounter'],
                    [
                        'last_run_at' => now(),
                        'description' => 'update data kunjungan yang telah di input diagnosanya oleh petugas RM, rubah status nya menjadi selesai'
                    ]
                );
            });
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
