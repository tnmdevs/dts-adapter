<?php

namespace TNM\DTS\Services\BundleSubscription;

use TNM\CPS\Services\IDTSClient;
use TNM\DTS\Responses\DTSResult;

class BundleSubscriptionClient implements IDTSClient
{
    private string $msisdn;
    private string $bundleCacheId;
    private float $price;
    private float $size;
    private string $callbackUrl;
    private string $tariffId;
    private string $counterId;
    private IBundleSubscriptionService $service;

    public function __construct(
        string $msisdn,
        string $bundleCacheId,
        float  $price,
        float  $size,
        string $callbackUrl,
        string $tariffId,
        string $counterId,
    )
    {
        $this->msisdn = $msisdn;
        $this->bundleCacheId = $bundleCacheId;
        $this->price = $price;
        $this->size = $size;
        $this->callbackUrl = $callbackUrl;
        $this->tariffId = $tariffId;
        $this->counterId = $counterId;
        $this->service = app(IBundleSubscriptionService::class);
    }

    public function query(): DTSResult
    {
        return $this->service->query([
            'msisdn' => $this->msisdn,
            'bundleCacheId' => $this->bundleCacheId,
            'price' => $this->price,
            'size' => $this->size,
            'callbackUrl' => $this->callbackUrl,
            'tariffId' => $this->tariffId,
            'counterId' => $this->counterId,
        ]);
    }
}
