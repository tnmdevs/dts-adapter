<?php

namespace TNM\DTS\Responses;

use stdClass;

class DTSResult
{
    private ?stdClass $result;

    public function __construct(?string $result)
    {
        $this->result = json_decode($result);
    }

    public function getMessage(): string
    {
        return $this->result->statusDescription;
    }

    public function array(): array
    {
        return json_decode(json_encode($this->result), true);
    }

    public function hasNoContent(): bool
    {
        return !$this->hasContent();
    }

    public function hasContent(): bool
    {
        return !is_null($this->result->status);
    }

    public function getBody(): array
    {
        return $this->array();
    }

    public function getContents(): array
    {
        return $this->array();
    }

    public function notSuccessful(): bool
    {
        return !$this->success();
    }

    public function success(): bool
    {
        return $this->status() == 202;
    }

    public function status(): int
    {
        return $this->result->status;
    }
}
