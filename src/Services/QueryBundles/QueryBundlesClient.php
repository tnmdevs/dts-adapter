<?php

namespace TNM\DTS\Services\QueryBundles;


use TNM\DTS\Responses\QueryBundles\IQueryBundlesResponse;

class QueryBundlesClient
{
    private string $msisdn;
    private IQueryBundlesService $service;

    public function __construct(string $msisdn)
    {
        $this->msisdn = msisdn($msisdn)->internationalize();
        $this->service = app(IQueryBundlesService::class);
    }


    public function query(): IQueryBundlesResponse
    {
        return $this->service->query($this->msisdn);
    }
}
