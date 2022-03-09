<?php

namespace TNM\DTS\Services\QueryBundles;

use TNM\DTS\Responses\IQueryBundleResponse;

interface IQueryBundlesService
{
    public function query(string $msisdn): IQueryBundleResponse;
}
