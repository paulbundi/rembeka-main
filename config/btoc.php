<?php

return [
    /*
     * Settings for Mpesa B2C config.
     */
    'sandbox' => env('B2C_USE_SANDBOX', true),
    'initiator_name' => 'rembekaapi',
    'initiator_password' => 'Qwerty@123',
    'short_code' => '3031827',
    'consumer_key' => 'Nz1xgvsxSaCjN9gclJItkVAwr8eoJKxn',
    'consumer_secret' => 'kMUQ68oBf2hXvYHM',
    'queue_timeout_url' => 'https://rembeka.com/b2c_timeout',
    'result_url' => 'https://rembeka.com/b2c_results',
    'command_id' => 'SalaryPayment',
    'sand_box_cert_file' => 'pstudioh_sandbox.cer',
    'prod_cert_file' => 'pstudioh_prod.cer',
];
