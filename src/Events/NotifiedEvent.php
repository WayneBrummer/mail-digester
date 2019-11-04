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
     * Undocumented function.
     *
     * @param object $user
     */
    public function __construct(object $notification)
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
