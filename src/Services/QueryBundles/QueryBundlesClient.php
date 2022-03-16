<?php

namespace TNM\DTS\Services\QueryBundles;

use TNM\DTS\Responses\IQueryBundleResponse;

class QueryBundlesClient
{
    private string $msisdn;
    private IQueryBundlesService $service;

    public function __construct(string $msisdn)
    {
        $this->msisdn = msisdn($msisdn)->internationalize();
        $this->service = app(IQueryBundlesService::class);
    }


    public function query(): IQueryBundleResponse
    {
        return $this->service->query($this->msisdn);
    }
}
