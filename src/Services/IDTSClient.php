<?php

namespace TNM\DTS\Services;

use TNM\DTS\Responses\DTSResult;

interface IDTSClient
{
    public function query(): DTSResult;
}
