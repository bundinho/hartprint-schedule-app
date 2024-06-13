<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Changeover configuration values
    |--------------------------------------------------------------------------
    |
    | This configuration contains the factoring changeover "delay" (in minutes)
    |
    */
    'changeover' => [
        /*
            Changeover delay between switching two types of products (in minutes)
        */
        'delay' => env('CHANGEOVER_DELAY', 30),
    ],
];
