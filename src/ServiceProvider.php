<?php

namespace Pace\MailDigester;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Pace\MailDigester\Console\SendUnreadDigest;

class ServiceProvider extends IlluminateServiceProvider
{
    const FREQUENCY = ['daily', 'weekly', 'monthly'];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerCommands();
        $this->app->register(EventServiceProvider::class);
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

                    $schedule->command('digest:unread')
                        ->{$frequency}($occurrence)
                        ->at($config['at']);
                }
            }
        });
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
