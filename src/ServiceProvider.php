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

    /**
     * Registers the php artisan send:digest command.
     */
    public function registerCommands() : void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([SendUnreadDigest::class]);
        }
    }

    /**
     * Required boot method for when starting the package.
     */
    public function boot()
    {
        if (!\config('mail-digester.enabled', false)) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->configure();
            $this->publishViews();
        }
        $this->app->booted(function () {
            $this->triggerSceduleAction($this->app->make(Schedule::class));
        });

        app('router')->aliasMiddleware('notification-middleware', NotificationMiddleware::class);
    }

    /**
     * Setup for package but packing the config file.
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

    /**
     * Publishes a basic mail view for "digests".
     */
    protected function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views/mails' => resource_path('views/mails'),
        ]);
    }

    private function triggerSceduleAction($schedule)
    {
        foreach (config('mail-digester.frequency', ['daily']) as $frequency) {
            //In array of accepted frequency
            if (\in_array($frequency, self::FREQUENCY, true)) {
                $occurrence = null;
                if (!\in_array($frequency, ['daily'], true)) {
                    $frequency  = 'On';
                    $occurrence = config('mail-digester.occurrence', null);
                }

                $schedule->command('mail-digest:unread')
                    ->{$frequency}($occurrence)
                    ->at(config('mail-digester.at', '16:00'));
            }
        }
    }
}
