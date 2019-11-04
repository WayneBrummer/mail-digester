<?php

namespace Pace\MailDigester\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Pace\MailDigester\Notifications\MailDigestNotification;

class Notification extends Model
{
    use Notifiable;

    protected $fillable = ['read_at'];

    public function sendMailDigesterNotification($user)
    {
        $user->notify(new MailDigestNotification($user));
    }
}
