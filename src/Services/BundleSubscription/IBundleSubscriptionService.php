<?php

namespace TNM\DTS\Services\BundleSubscription;

use TNM\DTS\Responses\DTSResult;

interface IBundleSubscriptionService
{
    public function query(array $attributes): DTSResult;
}
