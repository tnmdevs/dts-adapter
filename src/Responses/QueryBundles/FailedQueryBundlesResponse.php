<?php

namespace TNM\DTS\Responses\QueryBundles;

use TNM\DTS\Responses\DTSFailedResponse;

class FailedQueryBundlesResponse extends DTSFailedResponse implements IQueryBundlesResponse
{
    public function getSnapiBundles(): array
    {
        return [];
    }
}
