<?php

namespace TNM\DTS\Responses;

abstract class DTSFailedResponse
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function notSuccessful(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
