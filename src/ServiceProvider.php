<?php

namespace Pace\MailDigester;

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
}
