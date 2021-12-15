<?php

namespace TNM\DTS\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use TNM\DTS\Events\DTSExceptionEvent;
use TNM\DTS\Events\DTSRequestEvent;
use TNM\DTS\Events\DTSResponseEvent;
use TNM\DTS\Listeners\DTSExceptionListener;
use TNM\DTS\Listeners\DTSRequestListener;
use TNM\DTS\Listeners\DTSResponseListener;

class DTSEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DTSResponseEvent::class => DTSResponseListener::class,
        DTSRequestEvent::class => DTSRequestListener::class,
        DTSExceptionEvent::class => DTSExceptionListener::class
    ];

    public function boot()
    {

    }
}