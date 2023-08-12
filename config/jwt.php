<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued token will be
    | considered expired. If this value is null, JWT token will be expired
    | in 5 minutes. This won't tweak the lifetime of first-party sessions.
    |
    */

    'expiration' => env('JWT_EXPIRATION', 5),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the JWT encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('JWT_KEY', 'mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw='),
];
