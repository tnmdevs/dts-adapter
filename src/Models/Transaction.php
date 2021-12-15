<?php

namespace TNM\DTS\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'dts_transactions';
    protected $guarded = [];

    public function hasResult(): bool
    {
        return !$this->isPending();
    }

    public static function findById(string $conversationId): ?self
    {
        return static::where('transaction_id', $conversationId)->first();
    }

    public function isPending(): bool
    {
        return $this->{'status'} == null;
    }

    public function getResult(): ?string
    {
        return $this->{'result_body'};
    }
}