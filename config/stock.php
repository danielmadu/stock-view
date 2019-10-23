<?php

return [
    'drivers' => [
        'iex' => [
            'secret' => env('IEX_SECRET', null),
            'publishable' => env('IEX_PUBLISHABLE', null),
            'api_url' => 'https://cloud.iexapis.com/',
        ]
    ]
];
