<?php

namespace TNM\DTS\Services\QueryBundles;

use TNM\DTS\Responses\IQueryBundleResponse;

class QueryBundlesClient
{
    private string $msisdn;
    private IQueryBundlesService $service;

    public function __construct(string $msisdn)
    {
//       TODO find out the number format
        $this->msisdn = msisdn($msisdn)->humanize();
        $this->service = app(IQueryBundlesService::class);
    }


    public function query(): IQueryBundleResponse
    {
        return $this->service->query($this->msisdn);
    }
}
