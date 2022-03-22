<?php

namespace TNM\DTS\Responses;

use Illuminate\Http\Client\Response;
use TNM\DTS\Services\DTSFakeBaseService;

class DTSFakeResponse extends DTSFakeBaseService
{
    protected function makeRequest(array $attributes): Response
    {
        return new Response(new HttpResponse());
    }
}
