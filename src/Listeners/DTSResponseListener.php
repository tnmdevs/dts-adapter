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
        $conversation = Transaction::findById($event->attributes['trans_id']);

        $now = microtime(true) * 1000;
        $params = [
            'response_at' => $now,
            'response_milliseconds' => $now - $conversation->{'requested_at'},
            'response_body' => $event->response->toString(),
            'response_message' => $event->response->getMessage(),
        ];
        if ($event->response->isSync())
            $params = array_merge($params, [
                'result_at' => $now,
                'result_milliseconds' => $now - $conversation->{'requested_at'},
                'result_message' => $event->response->getMessage(),
                'status' => $event->response->status(),
                'success' => $event->response->success(),
            ]);

        $conversation->update($params);
    }
}
