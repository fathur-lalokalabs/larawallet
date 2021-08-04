<?php

return [

    /*
    |--------------------------------------------------------------------------
    | GETOTP Config
    |--------------------------------------------------------------------------
    |
    | You can over ride the config value with env
    |
    */

    'endpoint' => env('GETOTP_ENDPOINT', 'https://otp.dev/api/verify/'),

    'api_key' => env('GETOTP_API_KEY'),

    'api_token' => env('GETOTP_API_TOKEN'),
    
];