<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Account
    |--------------------------------------------------------------------------
    */
    'default' => env('DEFAULT_MPESA_ACCOUNT', 'staging'),

    /*
    |--------------------------------------------------------------------------
    | Native File Cache Location
    |--------------------------------------------------------------------------
    */
    'cache_location' => '../cache',

    /*
    |--------------------------------------------------------------------------
    | Accounts
    |--------------------------------------------------------------------------
    */
    'accounts' => [
        'staging' => [
            'sandbox' => false,
            'key' => '4v2pGUsZ41B0wFdEpCgzxsrB0OEfRUsa',
            'secret' => 'YW8RXCvq4LHAkQkL',
            'initiator' => 'apitest363',
            'id_validation_callback' => env('APP_URL') . '/payment-validation?secret=12345678',
            'lnmo' => [
                'shortcode' => '174379',
                'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                'callback' => env('APP_URL') . '/callback?secret=some_secret_hash_key',
            ],
        ],

        'production' => [
            'sandbox' => true,
            'key' => 'lUYboXH4GOHJLUWLl2BYGpGmTsSB5HiG',
            'secret' => 'lbInArJoXa8jV2TY',
            'initiator' => 'rembekaapi',
            'id_validation_callback' => env('APP_URL') . '/invalid-stk?secret=' . env('MPESA_CALLBACK_SECRET', '22rembeka20'),
            'lnmo' => [
                'paybill' => 4087941,
                'shortcode' => 4087941,
                'passkey' => '2fafb453d264c16273fda73f38af3aceabc2bcbcbece240df63f73e7b3023714',
                'callback' => env('APP_URL') . '/payment_confirmation?secret=' . env('MPESA_CALLBACK_SECRET', '22rembeka20'),
            ],
        ],
    ],
];
