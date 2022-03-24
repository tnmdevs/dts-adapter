<?php

namespace TNM\DTS\Services\QueryBundles;


use TNM\DTS\Responses\QueryBundles\IQueryBundlesResponse;

interface IQueryBundlesService
{
    public function query(string $msisdn): IQueryBundlesResponse;
}
