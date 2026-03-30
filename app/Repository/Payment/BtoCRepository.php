<?php

namespace  App\Repository\Payment;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

class BtoCRepository
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $securityCredentials;


    /**
     * Define access token.
     *
     * @var string
     */
    protected $token;

    /**
     * C2B constructor.
     */
    public function __construct()
    {
        $this->config = Config::get('btoc');
        $this->tokenVerifier();
        $this->setSecurityCredentials();
    }

    /**
     * Initialize Mpesa payment.
     *
     * @param User $user
     * @param int  $amount
     *
     * @return void
     */
    public function makeWithdraw($amount, User $user, String $occasion, ?string $commandId = null, ?string $comment = null)
    {
        $url = $this->config['sandbox'] ?
         'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest' :
         'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
        // $sec = 'UuCBPkMNEHL7p/La/nlfpRj42PVdqEvNsExiQN6qac5FH4zSEdadx1FeFXyf4tREJjAkIfXJYnEqKmnoBjF/m/yehLNd1MLIrjQ4NXOfd5skbg6oI8HUsyJKvLuD4gHo5/3ouXvNgCeZ8M+u6j0JM69/TtbbhEuGQTvvJG/YAicfFtPRkcnKB0xZjCyfYYXmabuwpwGAIqNtqFqk8gJGP7g4nZfGpMh7vazZLh2k/9Skdd8K1cqVBjUp6xj7/YA6qF13TUc868oDsjH59LfcAz2qzRzy/6X7bW6CxzvHPeiO9T9XZWU7Q8fBbvBjbMCi4E7Xx52yA7S/GCRJaT88eg==';

        $commandId = (isset($commandId) && in_array($commandId, ['SalaryPayment', 'BusinessPayment', 'PromotionPayment'])) ?
            $commandId : $this->config['command_id'];
        $data['InitiatorName'] = $this->config['initiator_name'];
        $data['CommandID'] = $commandId;
        $data['SecurityCredential'] = $this->securityCredentials;
        $data['QueueTimeOutURL'] = $this->config['queue_timeout_url'];
        $data['ResultURL'] = $this->config['result_url'];
        $data['Amount'] = $amount;
        $data['PartyA'] = $this->config['short_code'];
        $data['PartyB'] = $this->config['sandbox'] ? '254723835186' : '254'.substr($user->phone, -9);
        $data['Remarks'] = $comment ?? 'Withdraw from your Rembeka wallet';
        $data['occasion'] = $occasion;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getDefaultHeader());
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * Get Headers.
     *
     * @return array
     */
    public function getDefaultHeader():array
    {
        return [
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->token,
        ];
    }

    /**
     * generate the security credentials security key.
     *
     * @return self::class
     */
    public function setSecurityCredentials()
    {
        $publicKey = $this->config['sandbox'] ?
            file_get_contents(storage_path().'/'.$this->config['sand_box_cert_file']) :
            file_get_contents(storage_path().'/'.$this->config['prod_cert_file']);

        $password = $this->config['initiator_password'];

        \openssl_public_encrypt($password, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        $this->securityCredentials = \base64_encode($encrypted);
    }

    /**
     * Verify and get new token if needed.
     *
     * @return void
     */
    public function tokenVerifier(): void
    {
        // dd(json_decode(Redis::get('btoc')));
        // $this->token =  Redis::get('btoc') == null ? $this->generateToken() :
        //      (Carbon::parse(json_decode(Redis::get('btoc'))->expires_in)->lte(Carbon::now()) ?
        //      $this->generateToken() :
        //      json_decode(Redis::get('btoc'))->access_token);
        $this->token = $this->generateToken();
    }

    /**
     * Generate access token.
     *
     * @return string
     */
    public function generateToken():string
    {
        $url = $this->config['sandbox'] ?
        'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' :
        'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $credentials = base64_encode($this->config['consumer_key'].':'.$this->config['consumer_secret']);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic '.$credentials]); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        try {
            $response = json_decode(curl_exec($curl));
            // Redis::set('btoc', json_encode([
            //         'expires_in'=>Carbon::now()->addMinutes(50),
            //         'access_token' =>$response->access_token,
            //         'expires' =>$response->expires_in
            //     ]));
        } catch (Exception $e) {
        } finally {
            curl_close($curl);
        }

        return $response->access_token;
    }
}
