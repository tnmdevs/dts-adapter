<?php

namespace TNM\DTS\Services\QueryBundles;

use TNM\DTS\Responses\DTSResult;

interface IQueryBundlesService
{
    public function query(array $attributes, string $resultClass = DTSResult::class): DTSResult;
}