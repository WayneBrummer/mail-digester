<?php

namespace Pace\MailDigester\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use Notifiable;

    protected $fillable = ['read_at'];
}
