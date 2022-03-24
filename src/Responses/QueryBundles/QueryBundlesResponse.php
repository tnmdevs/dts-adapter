<?php

namespace TNM\DTS\Responses\QueryBundles;

use TNM\DTS\Responses\DTSResponse;

class QueryBundlesResponse extends DTSResponse implements IQueryBundlesResponse
{

    public function getSnapiBundles(): array
    {
        return collect($this->response->json('data'))
            ->filter(fn (array $bundle) => $bundle['type'] == 'SNAPI')
            ->filter(fn (array $bundle) => !preg_match('/gift/i', $bundle['name']))
            ->values()->toArray();
    }

    public function getMessage(): string
    {
        return $this->response->reason();
    }
}
