<?php

namespace TNM\DTS\Services\QueryBundles;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use TNM\DTS\Events\DTSExceptionEvent;
use TNM\DTS\Events\DTSRequestEvent;
use TNM\DTS\Events\DTSResponseEvent;
use TNM\DTS\Factories\TransactionIDFactory;
use TNM\DTS\Responses\IQueryBundleResponse;
use TNM\DTS\Responses\QueryBundleExceptionResponse;
use TNM\DTS\Responses\QueryBundlesResponse;

class QueryBundleService implements IQueryBundlesService
{
    protected function makeRequest(string $msisdn): Response
    {
        return Http::timeout(config('dts.timeout'))
            ->withHeaders([
                'User-Agent' => config('dts.user_agent'),
                'Content-Type' => 'application/json'
            ])
            ->get(sprintf('%s/ccc-handlers/dt/bundles?msisdn=%s&location=999-04-123-1234',
                    config('dts.base_url'),
                    $msisdn
                )
            );
    }

    public function query(string $msisdn): IQueryBundleResponse
    {
        $transactionId = (new TransactionIDFactory())->make();
        $attributes = ['msisdn' => $msisdn, 'trans_id' => $transactionId];
        Event::dispatch(new DTSRequestEvent($attributes, class_basename(static::class)));

        try {
            $response = new QueryBundlesResponse($transactionId, $this->makeRequest($msisdn));
            Event::dispatch(new DTSResponseEvent($attributes, $response));

            return $response;

        } catch (Exception $exception) {
            Event::dispatch(new DTSExceptionEvent($attributes, $exception));
            return new QueryBundleExceptionResponse();
        }
    }
}
