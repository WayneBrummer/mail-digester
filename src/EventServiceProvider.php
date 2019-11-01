<?php

namespace Pace\MailDigester;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Pace\MailDigester\Events\DigestEvent;
use Pace\MailDigester\Listeners\DigestMailListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DigestEvent::class => [
            DigestMailListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
