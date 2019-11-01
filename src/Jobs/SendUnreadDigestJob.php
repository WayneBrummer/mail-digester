<?php

namespace Pace\MailDigester\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pace\MailDigester\Events\DigestEvent;

class SendUnreadDigestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Job to insure that the current system does nto slow down.
     *
     * @param mixed $user
     */
    public function __construct($user)
    {
        $this->user   = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        event(new DigestEvent($this->user));
    }
}
