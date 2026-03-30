<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Account
    |--------------------------------------------------------------------------
    |
    | This is the default account to be used when none is specified.
    */

    'default' => env('DEFAULT_MPESA_ACCOUNT', 'staging'),

    /*
    |--------------------------------------------------------------------------
    | Native File Cache Location
    |--------------------------------------------------------------------------
    |
    | When using the Native Cache driver, this will be the relative directory
    | where the cache information will be stored.
    */

    'cache_location' => '../cache',

    /*
    |--------------------------------------------------------------------------
    | Accounts
    |--------------------------------------------------------------------------
    |
    | These are the accounts that can be used with the package. You can configure
    | as many as needed. Two have been setup for you.
    |
    | Sandbox: Determines whether to use the sandbox, Possible values: sandbox | production
    | Initiator: This is the username used to authenticate the transaction request
    | LNMO:
    |    paybill: Your paybill number
    |    shortcode: Your business shortcode
    |    passkey: The passkey for the paybill number
    |    callback: Endpoint that will be be queried on completion or failure of the transaction.
    |
    */

    'accounts' => [
        'staging' => [
            'sandbox' => true,
            'key' => '4v2pGUsZ41B0wFdEpCgzxsrB0OEfRUsa',
            'secret' => 'YW8RXCvq4LHAkQkL',
            'initiator' => 'apitest363',
            'id_validation_callback' => env('APP_URL').'/payment-validation?secret=12345678',
            'lnmo' => [
                'shortcode' => '174379',
                'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                'callback' => env('APP_URL').'/callback?secret=some_secret_hash_key',
            ]
        ],

        'production' => [
            'sandbox' => false,
            'key' => 'lUYboXH4GOHJLUWLl2BYGpGmTsSB5HiG',
            'secret' => 'lbInArJoXa8jV2TY',
            'initiator' => 'rembekaapi',
            'id_validation_callback' => 'https://rembeka.com/invalid-stk?secret=$2y$10$ukG/rKfGCgk1Ndc7pKKbN.wxlSKjKKnamGwlfQEuNA3ZOekx5RnaG',
            'lnmo' => [
                'paybill' => 4087941,
                'shortcode' => 4087941,
                'passkey' => '2fafb453d264c16273fda73f38af3aceabc2bcbcbece240df63f73e7b3023714',
                'callback' => 'https://rembeka.com/payment_confirmation?secret=$2y$10$ukG/rKfGCgk1Ndc7pKKbN.wxlSKjKKnamGwlfQEuNA3ZOekx5RnaG',
            ]
        ],
    ],
];
