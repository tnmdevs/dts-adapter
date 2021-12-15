<?php

namespace TNM\DTS\Responses;

use TNM\DTS\Models\Transaction;

class DTSResponse
{
    protected ?string $response;
    private array $prefixes = ['soapenv:', 'api:', 'res:'];

    public function __construct(?string $response = '')
    {
        $this->response = $response;
    }

    public function getConversation(): ?Conversation
    {
        $conversationId = $this->array()['Body']['Response']['Header']['OriginatorConversationID'];
        if (is_null($conversationId)) return null;

        return Conversation::where('conversation_id', $conversationId)->first();
    }

    public function customerDoesNotExist(): bool
    {
        return $this->status() == 20000003;
    }

    public function notSuccessful(): bool
    {
        return !$this->success();
    }

    public function success(): bool
    {
        return $this->status() == 0;
    }

    public function status(): string
    {

        return $this->valid() ? $this->array()['Body']['Response']['Body']['ResponseCode'] : 500;
    }

    private function valid(): bool
    {
        return isset($this->array()['Body']['Response']['Body']);
    }

    public function array(): array
    {
        return $this->toArray($this->response);
    }

    private function toArray(?string $xml): array
    {
        if (!is_string($xml)) return array();

        $value = json_decode(json_encode(simplexml_load_string($this->stripPrefixes($xml))), true);
        return is_array($value) ? $value : array();
    }

    private function stripPrefixes(string $xml): string
    {
        foreach ($this->prefixes as $prefix) $xml = str_replace($prefix, '', $xml);
        return $xml;
    }

    public function getMessage(): string
    {
        $message = $this->valid()
            ? $this->array()['Body']['Response']['Body']['ResponseDesc']
            : 'Request failed. Please try again later';

        return (new ErrorMessageTransformer($message))->getMessage();
    }

    public function toString(): string
    {
        return $this->response;
    }

    public function isValidationError(): ?bool
    {
        return in_array($this->status(), CBS::ERROR_CODES);
    }

    public function getTransaction():?Transaction
    {
        $conversationId = $this->array()['Body']['Response']['Header']['OriginatorConversationID'];
        if (is_null($conversationId)) return null;

        return Transaction::where('conversation_id', $conversationId)->first();
    }
}