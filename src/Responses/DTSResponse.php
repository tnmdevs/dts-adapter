<?php

namespace TNM\DTS\Responses;

use Illuminate\Http\Client\Response;
use TNM\DTS\Models\Transaction;

class DTSResponse
{
    protected ?Response $response;
    private string $transactionId;

    public function __construct(string $transactionId, ?Response $response = null)
    {
        $this->response = $response;
        $this->transactionId = $transactionId;
    }

    public function notSuccessful(): bool
    {
        return !$this->success();
    }

    public function success(): bool
    {
        return $this->response->successful() && $this->response['status'] == 1;
    }

    public function status(): string
    {
        return $this->response->status();
    }

    public function array(): array
    {
        return $this->response->json();
    }

    public function getMessage(): string
    {
       return $this->response->json('data.status');
    }

    public function toString(): string
    {
        return $this->response->body();
    }

    private function isAsync(): bool
    {
        return $this->response->json('data.status') && $this->response->json('data.status') == 'RECEIVED';
    }

    public function isSync(): bool
    {
        return !$this->isAsync();
    }

    public function getTransaction():?Transaction
    {
        return Transaction::where('transaction_id', $this->transactionId)->first();
    }
}
