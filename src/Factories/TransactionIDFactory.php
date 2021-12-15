<?php

namespace TNM\DTS\Factories;

class TransactionIDFactory
{
    private int $length;
    private string $prefix;

    public function __construct(int $length = 18, ?string $prefix = null)
    {
        $this->length = $length;
        $this->prefix = $prefix ?? substr(config('app.name'), 0, 3);
    }

    public function make()
    {
        return substr(sprintf("%s%s%s", $this->prefix, $this->getTime(), $this->getSuffix()), 0, $this->length);
    }

    private function getTime(): int
    {
        return (int)round(microtime(true) * 1000);
    }

    private function getSuffix(): string
    {
        $characters = "0123456789";

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < ($this->length - 13 - strlen($this->prefix)); $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}