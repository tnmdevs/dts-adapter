<?php

namespace TNM\DTS\Responses;

class QueryBundleExceptionResponse implements IQueryBundleResponse
{

    public function getBundles(): array
    {
        return [];
    }

    public function notSuccessful(): bool
    {
        return true;
    }
}
