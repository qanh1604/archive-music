<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $pathModule = base_path("Modules");
        if(file_exists($pathModule)) {
            $listModule = array_map('basename', File::directories($pathModule));
            foreach ($listModule as $module) {
                $realPath = $pathModule . '/' . $module . '/Commands/';
                $path = "\Modules\\{$module}\Commands\\";
                if(file_exists($realPath)){
                    collect(scandir($realPath))->each(function ($item) use ($path, $realPath) {
                        if (in_array($item, ['.', '..'])) return;

                        if (is_dir($realPath . $item)) {
                            $this->loadCommands($path . $item . '/');
                        }

                        if (is_file($realPath . $item)) {
                            $item = str_replace('.php', '', $item);
                            $class = str_replace('/', '\\', "{$path}$item");

                            if (class_exists($class)) {
                                $this->commands[] = $class;
                            }                  
                        }
                    });
                }
            }
        }

        require base_path('routes/console.php');
    }
}
