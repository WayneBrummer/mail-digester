<?php

return [
    //Is the application enabled to send "Summary" emails
    'enabled' => true,

    /*
     * Should mark summarized emails as read if digest mail is sent.
     * This will be preformed at the same time the 'digest' is
     * sent so it may have a bit of overhead.
     * Can be differed to in the Listener on the event trigger.
     */
    'mark_read' => false,

    /*
     * Default model for Users to inherit.
     * Can be changed to if User does not start from default Laravel standard space.
     */
    'users' => 'App\User',

    /*
     * Will trigger a email sent to users.
     * Can be used to overwrite the default function.
     * Build a new Listener to capture the event to do custom stuff.
     */
    'send_digest_notification' => true,
    /*
     * Identifier for middleware routes.
     * Can be overwritten.
     */
    'identifier' => 'notification_id',
];
