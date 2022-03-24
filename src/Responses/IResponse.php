<?php

namespace TNM\DTS\Responses;

interface IResponse
{
    public function notSuccessful(): bool;

    public function getMessage(): string;
}
