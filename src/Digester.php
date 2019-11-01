<?php

namespace Pace\MailDigester;

use Pace\MailDigester\Jobs\SendUnreadDigestJob;

class Digester
{
    private $userId;

    private $users;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->sendDigest();
    }

    /** Set users object up for transference. */
    public function setUsers()
    {
        $userId = $this->userId;

        $userModel = \config('mail-digester.users', 'App\User');

        $this->users = $userModel::where(function ($query) use ($userId) {
            if (!empty($userId)) {
                return $query->where('id', $userId);
            }
        })->get();
    }

    /** Retrieves Users if not already set */
    public function getUsers()
    {
        if (empty($this->users)) {
            $this->setUsers();
        }
    }

    public function sendDigest()
    {
        $this->getUsers();
        $this->dispatchDigestNotification();
    }

    private function dispatchDigestNotification()
    {
        foreach ($this->users as $user) {
            if (!$user->unreadNotifications->isEmpty()) {
                $dispatchJob = (new SendUnreadDigestJob($user));

                dispatch($dispatchJob);
            }

            // if (config('mail-digester.mark_read', false)) {
            //     $user->unreadNotifications()->markAsRead();
            // }
        }
    }
}
