<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        if (\Illuminate\Support\Facades\Schema::hasTable('bot_settings')) {
            $status = \App\Models\BotSetting::get('bot_status', 'enabled');
            if ($status === 'enabled') {
                $interval = \App\Models\BotSetting::get('bot_interval', 'hourly');

                switch ($interval) {
                    case '30min':
                        $schedule->command('bots:generate-activity')->everyThirtyMinutes();
                        break;
                    case 'hourly':
                        $schedule->command('bots:generate-activity')->hourly();
                        break;
                    case '4hours':
                        $schedule->command('bots:generate-activity')->everyFourHours();
                        break;
                    case 'twice_daily':
                        $schedule->command('bots:generate-activity')->twiceDaily(1, 13);
                        break;
                    case 'daily':
                        $schedule->command('bots:generate-activity')->daily();
                        break;
                }
            }
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
