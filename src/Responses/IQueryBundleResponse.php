<?php

namespace TNM\DTS\Responses;

interface IQueryBundleResponse
{
    public function getBundles(): array;

    public function notSuccessful(): bool;
}
