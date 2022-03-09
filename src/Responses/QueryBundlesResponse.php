<?php

namespace TNM\DTS\Responses;

class QueryBundlesResponse extends DTSResponse implements IQueryBundleResponse
{
    public function getBundles(): array
    {
        return $this->response->json('data');
    }
}
