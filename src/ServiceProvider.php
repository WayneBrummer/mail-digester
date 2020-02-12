<?php

namespace Pace\MailDigester;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Pace\MailDigester\Console\SendUnreadDigest;
use Pace\MailDigester\Http\Middleware\NotificationMiddleware;

class ServiceProvider extends IlluminateServiceProvider
{
    const FREQUENCY = ['daily', 'weekly', 'monthly'];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerCommands();
    }

    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([SendUnreadDigest::class]);
        }
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->configure();
            $this->publishViews();
        }
        $this->app->booted(function () {
            $config = config('mail-digester', []);

            if (!$config['enabled']) {
                return;
            }
            $schedule = $this->app->make(Schedule::class);

            foreach ($config['frequency'] ?? [] as $frequency) {
                if (\in_array($frequency, self::FREQUENCY, true)) {
                    $frequency .= ($frequency !== 'daily') ? 'On' : '';
                    $occurrence = ($frequency !== 'daily') ? $config['occurrence'] : null;

                    $schedule->command('mail-digest:unread')
                        ->{$frequency}($occurrence)
                        ->at($config['at']);
                }
            }
        });

        app('router')->aliasMiddleware('notification-middleware', NotificationMiddleware::class);
    }

    /**
     * Setup the configuration for Horizon.
     */
    protected function configure()
    {
        $this->publishes([
            __DIR__ . '/../config/mail-digester.php' => config_path('mail-digester.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/mail-digester.php',
            'mail-digester'
        );
    }

    protected function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views/mails' => resource_path('views/mails'),
        ]);
    }
}
