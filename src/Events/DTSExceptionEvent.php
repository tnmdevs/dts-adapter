<?php

namespace TNM\DTS\Events;

use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DTSExceptionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public Exception $exception;
    public array $attributes;

    public function __construct(array $attributes, Exception $exception)
    {
        $this->exception = $exception;
        $this->attributes = $attributes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}