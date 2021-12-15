<?php

namespace TNM\DTS\Services\QueryBundles;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use TNM\DTS\Services\DTSBaseService;

class QueryBundleService extends DTSBaseService implements IQueryBundlesService
{
    protected function makeRequest(array $attributes): Response
    {
        return Http::get(sprintf('%s/ccc-handlers/dt/bundles?msisdn=%s', config('dts.base_url'), $attributes['msisdn']));
    }
}