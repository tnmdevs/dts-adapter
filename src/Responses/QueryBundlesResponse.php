<?php

namespace TNM\DTS\Responses;

class QueryBundlesResponse extends DTSResponse
{
    public function getBundles(): array
    {
        return $this->response->json('data');
    }
}
