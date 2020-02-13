<?php

namespace Pace\MailDigester;

use Pace\MailDigester\Jobs\SendUnreadDigestJob;

class Digester
{
    private $userId;

    private $users;

    /**
     * The primary use case for this packages is to get summary notifications.
     *
     * @param null|int $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
        if (\config('mail-digester.enabled', false)) {
            $this->sendDigest();
        }
    }

    /**
     * Set users object up for transference.
     * This will ethier use the sigle user id specifed or all users who have un-read
     * notifications.
     */
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

    /** Retrieves Users if not already set. */
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

    /**
     * dispatched the job to send the notification.
     */
    private function dispatchDigestNotification() : void
    {
        foreach ($this->users as $user) {
            if (!$user->unreadNotifications->isEmpty()) {
                dispatch((new SendUnreadDigestJob($user)));
            }
        }
    }
}
