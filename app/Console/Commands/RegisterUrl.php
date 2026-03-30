<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegisterUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register c2b urls using v2';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization: Bearer ' . $this->generateAccessToken()]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'ShortCode' => 4087941,
            'ResponseType' => 'Completed',
            'ConfirmationURL' => 'https://rembeka.com/payment_confirmation?secret=$2y$10$ukG/rKfGCgk1Ndc7pKKbN.wxlSKjKKnamGwlfQEuNA3ZOekx5RnaG',
            'ValidationURL' => 'https://rembeka.com/payment_validation?secret=$2y$10$ukG/rKfGCgk1Ndc7pKKbN.wxlSKjKKnamGwlfQEuNA3ZOekx5RnaG'
        ]));

        $curlResponse = curl_exec($curl);

        dd($curlResponse);
        echo $curlResponse;
    }

    public function generateAccessToken()
    {
        $credentials = base64_encode('lUYboXH4GOHJLUWLl2BYGpGmTsSB5HiG:lbInArJoXa8jV2TY');

        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curlResponse = curl_exec($curl);
        $accessToken = json_decode($curlResponse);

        return $accessToken->access_token;
    }
}
