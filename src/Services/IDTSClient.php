<?php

namespace TNM\CPS\Services;

use TNM\DTS\Responses\DTSResult;

interface IDTSClient
{
    public function query(): DTSResult;
}