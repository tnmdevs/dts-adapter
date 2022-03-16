<?php

namespace TNM\DTS\Services\BundleSubscription;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use TNM\DTS\Services\DTSBaseService;

class BundleSubscriptionService extends DTSBaseService implements IBundleSubscriptionService
{
    protected function makeRequest(array $attributes): Response
    {
        return Http::withHeaders([
            'User-Agent' => config('dts.user_agent'),
            'x-client-used' => config('dts.user_agent')
        ])
            ->timeout('dts.timeout')
            ->post(sprintf('%s/ccc-handlers/dt/bundles?msisdn=%s', config('dts.base_url'), $attributes['msisdn']), [
                'bundleCacheId' => $attributes['bundleCacheId'],
                'price' => $attributes['price'],
                'size' => $attributes['size'],
                'callbackUrl' => $attributes['callbackUrl'],
                'tariffId' => $attributes['tariffId'],
                'counterId' => $attributes['counterId'],
            ]);
    }
}
