<?php

namespace Pace\MailDigester\Http\Middleware;

use Closure;
use Pace\MailDigester\Events\NotifiedEvent;

class NotificationMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->has(config('mail-digester.identifier'))) {
            event(new NotifiedEvent(request(config('mail-digester.identifier'))));
        }

        return $next($request);
    }
}
