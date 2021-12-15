<?php

namespace TNM\DTS\Services\QueryBundles;

use TNM\CPS\Services\IDTSClient;
use TNM\DTS\Responses\DTSResult;

class QueryBundlesClient implements IDTSClient
{
    private string $msisdn;
    private IQueryBundlesService $service;

    public function __construct(string $msisdn)
   {
//       TODO find out the number format
       $this->msisdn = msisdn( $msisdn)->humanize();
       $this->service=app(IQueryBundlesService::class);
   }


    public function query(): DTSResult
    {
        return $this->service->query([
            'msisdn'=>$this->msisdn
        ]);
    }
}