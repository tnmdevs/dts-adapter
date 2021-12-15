<?php

namespace TNM\CPS\Services;

use Illuminate\Support\Facades\Event;
use TNM\DTS\Events\DTSResultEvent;
use TNM\DTS\Models\Transaction;

trait Awaits
{
    protected function await(Transaction $transaction): ?string
    {
        for ($i = 0; $i < config('cps.await_loops'); $i++) {
            if ($transaction->fresh()->hasResult()) break;
            usleep(config('cps.await_sleep_milliseconds'));
        }

        Event::dispatch(new DTSResultEvent($transaction->fresh()));
        return $transaction->fresh()->getResult();
    }
}