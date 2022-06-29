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
            ->filter(fn (array $bundle) => !preg_match('/test/i', $bundle['name']))
            ->filter(fn (array $bundle) => $bundle['services'][0]!='Data' || preg_match('/2Hr/i', $bundle['label']) || preg_match('/4Hr/i', $bundle['label']))
            ->values()->toArray();
    }

    public function getMessage(): string
    {
        return $this->response->reason();
    }
}
