<?php

namespace Pace\MailDigester\Listeners;

use Pace\MailDigester\Events\DigestEvent;
use Pace\MailDigester\Models\Notification as Digest;

class DigestMailListener
{
    /**
     * Handle the event.
     *
     * @param DigestEvent $event
     */
    public function handle(DigestEvent $event)
    {
        if (config('mail-digester.send_digest_notification', false)) {
            (new Digest())->sendMailDigesterNotification($event->user);
        }
    }
}
