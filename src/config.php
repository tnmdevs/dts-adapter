<?php

return [
    'base_url' => 'http://localhost',
    'user_agent' => null,

    'await' => [
        'loops' => 100,
        'sleep_milliseconds' => 100,
    ],

    'callback' => [
        'prefix' => 'api/dts',
        'middleware' => null
    ],

    'timeout' => 10
];
