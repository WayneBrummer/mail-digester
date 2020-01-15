<?php

namespace Pace\MailDigester\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Used so that the user has the choice to add listeners to pull the digest if that want.
 */
class NotifiedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    public $notification;

    /**
     * Notification UUID string to make as read.
     *
     * @param string $notification
     */
    public function __construct(string $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('mail-notification-read');
    }
}
