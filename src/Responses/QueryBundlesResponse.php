<?php

namespace TNM\DTS\Responses;

class QueryBundlesResponse extends DTSResponse implements IQueryBundleResponse
{

    public function getBundles(): array
    {
        return $this->response->json('data');
    }

    public function getSnapiBundles(): array
    {
        return collect($this->getBundles())
            ->filter(fn (array $bundle) => $bundle['type'] == 'SNAPI')
            ->filter(fn (array $bundle) => !preg_match('/gift/i', $bundle['name']))
            ->values()->toArray();
    }

    public function getMessage(): string
    {
        return $this->response->reason();
    }
}
