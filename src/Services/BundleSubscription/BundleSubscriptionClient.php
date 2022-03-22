<?php

namespace TNM\DTS\Services\BundleSubscription;

use TNM\DTS\Services\IDTSClient;
use TNM\DTS\Factories\TransactionIDFactory;
use TNM\DTS\Responses\DTSResult;

class BundleSubscriptionClient implements IDTSClient
{
    private string $msisdn;
    private string $bundleCacheId;
    private float $price;
    private float $size;
    private string $tariffId;
    private string $counterId;
    private IBundleSubscriptionService $service;

    public function __construct(
        string $msisdn,
        string $bundleCacheId,
        float  $price,
        float  $size,
        string $tariffId,
        string $counterId
    )
    {
        $this->msisdn = msisdn($msisdn)->internationalize();
        $this->bundleCacheId = $bundleCacheId;
        $this->price = $price;
        $this->size = $size;
        $this->tariffId = $tariffId;
        $this->counterId = $counterId;
        $this->service = app(IBundleSubscriptionService::class);
    }

    public function query(): DTSResult
    {
        $transactionId = (new TransactionIDFactory())->make();

        return $this->service->query([
            'trans_id' => $transactionId,
            'msisdn' => $this->msisdn,
            'bundleCacheId' => $this->bundleCacheId,
            'price' => $this->price,
            'size' => $this->size,
            'callbackUrl' => sprintf('%s,%s/callback/%s', config('dts.callback_ip'), config('dts.callback.prefix'),
                $transactionId),
            'tariffId' => $this->tariffId,
            'counterId' => $this->counterId,
        ]);
    }
}
