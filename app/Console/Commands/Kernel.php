<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar command artisan custom yang tersedia
     */
    protected $commands = [
        // Daftarkan command custom kamu di sini jika perlu
        // \App\Console\Commands\KirimPengingatJadwal::class,
    ];

    /**
     * Atur jadwal task artisan di sini.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('jadwal:ingatkan')->everyMinute();
    }

    /**
     * Daftarkan file command di sini.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
