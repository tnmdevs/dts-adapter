<?php

namespace TNM\DTS\Listeners;

use TNM\DTS\Events\DTSResponseEvent;
use TNM\DTS\Models\Transaction;

class DTSResponseListener
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

    public function handle(DTSResponseEvent $event)
    {
        $conversation = Transaction::findById($event->attributes['transaction_id']);

        $now = microtime(true) * 1000;
        $conversation->update([
            'response_at' => $now,
            'response_milliseconds' => $now - $conversation->{'requested_at'},
            'response_body' => $event->response->toString(),
            'response_message' => $event->response->getMessage(),
        ]);
    }
}