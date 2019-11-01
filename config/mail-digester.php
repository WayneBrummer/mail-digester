<?php

return [
    //Is the application enabled to send "Summary" emails
    'enabled' => true,

    /*
     * The frequency in which the summary can build up too.
     * ['daily', 'weekly', 'monthly']
     * * Please note the using the monthly summary will incur a large email string.
    */
    'frequency' => ['daily'],
    /*
     * The time at which the email will be sent.
     * Format of requested time is 'hh:mm'
     * Required attribute format is hh:mm
     */
    'at' => '16:00',
    /*
     * In case of weekly or monthly.
     * Format of integer is required.
     * =========================================================================
     * Daily will be null as it will listen to the 'at' attribute.
     * Weekly goes up to 7.
     * Monthly goes up to 28. and then `last_day` may be used.
     */
    'occurrence' => null,

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
];
