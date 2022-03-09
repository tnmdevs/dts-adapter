<?php

namespace TNM\DTS\Responses;

class QueryBundleExceptionResponse extends DTSResponse implements IQueryBundleResponse
{

    public function getBundles(): array
    {
        return [];
    }
}
