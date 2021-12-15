<?php

namespace TNM\DTS\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use TNM\DTS\Responses\DTSResponse;


class DTSResponseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $attributes;
    public DTSResponse $response;

    public function __construct(array $attributes, DTSResponse $response)
    {
        $this->attributes = $attributes;
        $this->response = $response;
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