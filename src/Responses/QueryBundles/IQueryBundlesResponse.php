<?php

namespace TNM\DTS\Responses\QueryBundles;

use TNM\DTS\Responses\IResponse;

interface IQueryBundlesResponse extends IResponse
{
    public function getSnapiBundles(): array;
}
