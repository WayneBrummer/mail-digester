<?php

namespace Pace\MailDigester\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailDigestNotification extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user          = $this->user;
        $notifications = $user->unreadNotifications->pluck('data');

        $notificationsUrl = route('notifications.index');

        // dd(\compact('notifications'));

        return (new MailMessage())
            ->subject("Mail Digest: {$user->first_name} {$user->last_name},")
            ->greeting("Hello {$user->first_name} {$user->last_name} ")
            ->markdown('mails.email-digest', \compact('user', 'notifications'));
    }
}
