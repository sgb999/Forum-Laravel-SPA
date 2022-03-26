<?php

declare(strict_types=1);

namespace App\Console;

use App\Models\TemporaryFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use function rmdir;
use function strtotime;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        /*
         * to delete all tempoaray files older than 24 hours
         */
        $schedule->call(function () {
            $files = TemporaryFile::where('created_at' < strtotime('-1 day'))
                ->get();
            foreach ($files as $file) {
                rmdir(storage_path('app/public/avatars/tmp/' . $file->folder));
                $file->delete();
            }
        })->daily();
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
