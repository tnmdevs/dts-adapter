<?php

namespace TNM\DTS\Services\BundleSubscription;


use TNM\DTS\Responses\BundleSubscription\IBundleSubscriptionResponse;

interface IBundleSubscriptionService
{
    public function query(array $attributes): IBundleSubscriptionResponse;
}
