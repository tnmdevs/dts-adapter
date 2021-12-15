<?php


namespace TNM\DTS\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Event;
use TNM\CPS\Services\Awaits;
use TNM\DTS\Events\DTSExceptionEvent;
use TNM\DTS\Events\DTSRequestEvent;
use TNM\DTS\Events\DTSResponseEvent;
use TNM\DTS\Responses\DTSResponse;
use TNM\DTS\Responses\DTSResult;

abstract class DTSBaseService
{
    use Awaits;

    abstract protected function makeRequest(array $attributes): Response;

    public function query(array $attributes, string $resultClass = DTSResult::class): DTSResult
    {
        Event::dispatch(new DTSRequestEvent(['payload' => $attributes, 'body' => $attributes], class_basename(static::class)));

        try {
            $response = $this->makeRequest($attributes);

            $DTSResponse = new DTSResponse($response->json());
            Event::dispatch(new DTSResponseEvent($attributes, $DTSResponse));

            $transaction = $DTSResponse->success() ? $DTSResponse->getTransaction() : null;

            if ($DTSResponse->notSuccessful() || is_null($transaction)) {
                return new $resultClass($DTSResponse->getMessage());
            }

            return new $resultClass($this->await($transaction));

        } catch (Exception $exception) {
            Event::dispatch(new DTSExceptionEvent($attributes, $exception));
            return new $resultClass($exception->getMessage());
        }
    }
}
