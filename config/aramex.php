<?php

return [
    'base_url' => env('ARAMEX_BASE_URL', 'https://api.aramex.net'),
    'username' => env('ARAMEX_USERNAME', ''),
    'password' => env('ARAMEX_PASSWORD', ''),
    'account_number' => env('ARAMEX_ACCOUNT_NUMBER', ''),
    'account_pin' => env('ARAMEX_ACCOUNT_PIN', ''),
    'entity' => env('ARAMEX_ENTITY', ''),
    'country_code' => env('ARAMEX_COUNTRY_CODE', ''),
];
