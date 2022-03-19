<?php

namespace App\Console;

use App\Models\TempoarayFile;
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
        /*
         * to delete all tempoaray files older than 24 hours
         */
        $schedule->call(function () {
            $files = TempoarayFile::where('created_at' < strtotime('-1 day'))
                ->get();
            foreach ($files as $file){
                rmdir(storage_path('app/public/avatars/tmp/' . $file->folder));
                $file->delete();
            }
        })->daily();
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
