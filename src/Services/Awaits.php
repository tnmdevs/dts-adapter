<?php

namespace TNM\DTS\Services;

use Illuminate\Support\Facades\Event;
use TNM\DTS\Events\DTSResultEvent;
use TNM\DTS\Models\Transaction;

trait Awaits
{
    protected function await(Transaction $transaction): ?string
    {
        for ($i = 0; $i < config('dts.await.loops'); $i++) {
            if ($transaction->fresh()->hasResult()) break;
            usleep(config('dts.await.sleep_milliseconds') * 1000);
        }

        Event::dispatch(new DTSResultEvent($transaction->fresh()));
        return $transaction->fresh()->getResult();
    }
}
