<?php

namespace TNM\DTS\Listeners;

use TNM\DTS\Events\DTSExceptionEvent;
use TNM\DTS\Models\Transaction;

class DTSExceptionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(DTSExceptionEvent $event)
    {
        $conversation = Transaction::findById($event->attributes['transaction_id']);

        $now = microtime(true) * 1000;
        $conversation->update([
            'response_at' => $now,
            'response_milliseconds' => $now - $conversation->{'requested_at'},
            'response_body' => '',
            'response_message' => $event->exception->getMessage(),
        ]);
    }
}