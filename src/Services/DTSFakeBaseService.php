<?php


namespace TNM\DTS\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Event;
use TNM\DTS\Events\DTSExceptionEvent;
use TNM\DTS\Events\DTSRequestEvent;
use TNM\DTS\Events\DTSResponseEvent;
use TNM\DTS\Responses\DTSResponse;
use TNM\DTS\Responses\DTSResult;

abstract class DTSFakeBaseService
{
    use Awaits;

    abstract protected function makeRequest(array $attributes): Response;

    public function query(array $attributes, string $resultClass = DTSResult::class): DTSResult
    {
        Event::dispatch(new DTSRequestEvent($attributes, class_basename(static::class)));

        $DTSResponse = new DTSResponse($attributes['transaction_id'], $this->makeRequest($attributes));
        Event::dispatch(new DTSResponseEvent($attributes, $DTSResponse));

        $transaction = $DTSResponse->success() ? $DTSResponse->getTransaction() : null;

        if ($DTSResponse->notSuccessful() || is_null($transaction)) {
            return new $resultClass($DTSResponse->getMessage());
        }

        return new $resultClass($this->await($transaction));

    }
}
