<?php

namespace TNM\DTS\Services\BundleSubscription;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use TNM\DTS\Events\DTSExceptionEvent;
use TNM\DTS\Events\DTSRequestEvent;
use TNM\DTS\Events\DTSResponseEvent;
use TNM\DTS\Responses\DTSResponse;
use TNM\DTS\Responses\DTSResult;
use TNM\DTS\Services\Awaits;

class BundleSubscriptionService implements IBundleSubscriptionService
{
    use Awaits;

    protected function makeRequest(array $attributes): Response
    {
        return Http::withHeaders([
            'User-Agent' => config('dts.user_agent'),
            'x-client-used' => config('dts.user_agent')
        ])
            ->timeout(config('dts.timeout'))
            ->post(sprintf('%s/ccc-handlers/dt/bundles?msisdn=%s', config('dts.base_url'), $attributes['msisdn']), [
                'bundleCacheId' => $attributes['bundleCacheId'],
                'price' => $attributes['price'],
                'size' => $attributes['size'],
                'callbackUrl' => $attributes['callbackUrl'],
                'tariffId' => $attributes['tariffId'],
                'counterId' => $attributes['counterId'],
            ]);
    }

    public function query(array $attributes): DTSResult
    {
        Event::dispatch(new DTSRequestEvent($attributes, class_basename(static::class)));

        try {
            $response = $this->makeRequest($attributes);

            $DTSResponse = new DTSResponse($attributes['transaction_id'], $response);
            Event::dispatch(new DTSResponseEvent($attributes, $DTSResponse));

            $transaction = $DTSResponse->success() ? $DTSResponse->getTransaction() : null;

            if ($DTSResponse->notSuccessful() || is_null($transaction)) {
                return new DTSResult($DTSResponse->getMessage());
            }

            return new DTSResult($this->await($transaction));

        } catch (Exception $exception) {
            Event::dispatch(new DTSExceptionEvent($attributes, $exception));
            return new DTSResult($exception->getMessage());
        }
    }

}
