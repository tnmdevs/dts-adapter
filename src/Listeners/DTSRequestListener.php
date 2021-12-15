<?php

namespace TNM\DTS\Listeners;

use TNM\DTS\Events\DTSRequestEvent;
use TNM\DTS\Models\Transaction;

class DTSRequestListener
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

    public function handle(DTSRequestEvent $event)
    {
        Transaction::create([
            'msisdn' => $event->attributes['payload']['msisdn'],
            'service' => $event->service,
            'transaction_id' => $event->attributes['payload']['transaction_id'],
            'requested_at' => microtime(true) * 1000,
            'request' => json_encode($event->attributes['payload']),
            'request_body' => $event->attributes['body'],
        ]);
    }
}