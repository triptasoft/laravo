<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Guards
    |--------------------------------------------------------------------------
    |
    | Define the guards provided by your package here.
    |
    */

    'guards' => [
        'api' => [
            'driver' => 'passport',
            'provider' => 'users', // Replace with your user provider name
        ],
    ],

];
