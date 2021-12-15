<?php

namespace TNM\DTS\Responses;

class DTSResult
{
    private ?string $result;
    private ?string $namespace;
    private array $prefixes = ['soapenv:', 'api:', 'res:'];


    public function __construct(?string $result, ?string $namespace = null)
    {
        $this->result = $result;
        $this->namespace = $namespace;
    }

    public function getMessage(): string
    {
        return $this->valid()
            ? $this->array()['Body']['Result']['Body']['ResultDesc']
            : 'Request failed. Please try again later';
    }

    private function valid(): bool
    {
        return isset($this->array()['Body']['Result']['Body']);
    }

    public function array(): array
    {
        return $this->toArray($this->result);
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

    public function hasNoContent(): bool
    {
        return !$this->hasContent();
    }

    public function hasContent(): bool
    {
        return isset($this->getBody()[$this->namespace]);
    }

    public function getBody(): array
    {
        return $this->valid() ? $this->array()['Body']['Result']['Body'] : [];
    }

    public function getContents(): array
    {
        return $this->hasContent() ? $this->getBody()[$this->namespace] : [];
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
        return $this->valid() ? $this->array()['Body']['Result']['Body']['ResultCode'] : 500;
    }
}