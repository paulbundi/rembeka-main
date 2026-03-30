<?php

namespace  App\Repository\Payment;

use App\Jobs\PaymentValidated;
use App\Models\MpesaBalance;
use App\Models\MpesactobDeposit;
use App\Models\MpesaTopUpTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\WalletAudit;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SmoDav\Mpesa\Laravel\Facades\STK;

class MpesaValidationRepository
{
    /**
     * Validate user account top up via stk validate SmoDav.
     *
     * @return void
     */
    public function validateTopUp(?int $transId)
    {
        $transaction = null;

        if ($transId) {
            $transaction = MpesaTopUpTransaction::where('id', $transId)
                ->where('status', MpesaTopUpTransaction::STATUS_PENDING)
                ->first();
        } else {
            $transaction = MpesaTopUpTransaction::where('user_id', auth()->id())
                ->where('status', MpesaTopUpTransaction::STATUS_PENDING)
                ->latest()
                ->first();
        }

        if (! $transaction || $transaction == null) {
            return ['type' => 'error', 'message' => 'home'];
        }

        $response = STK::validate($transaction->checkout_request_id);

        if (property_exists($response, 'ResultCode') && property_exists($response, 'ResponseCode') && $response->ResultCode == '0' && $response->ResponseCode == '0') {
            $this->updateOrderStatus($transaction, true);

            return ['type' => 'success', 'message' => 'success', 'transaction' => $transaction];
        }

        if (property_exists($response, 'errorCode')) {
            $transaction->update([
                'customer_message' => $response->errorMessage,
                'status' => MpesaTopUpTransaction::STATUS_CANCELLED,
            ]);

            $this->updateOrderStatus($transaction, false);

            return [
                'type' => 'error',
                'message' =>$response->errorMessage ?: 'error'
            ];
        }
        if (property_exists($response, 'ResultCode') && $response->ResultCode != '0') {
            $transaction->update([
                'customer_message' => $response->ResultDesc,
                'status' => MpesaTopUpTransaction::STATUS_CANCELLED,
            ]);

            return [
                'type' => 'error',
                'message' =>$response->errorMessage ?? 'error'
            ];
        }

        return [
            'type' => 'error',
            'message' => 'error',
        ];
    }

    /**
     * fire order event
     *
     * @param MpesaTopUpTransaction $transaction
     * @param int                   $userId
     *
     * @return void
     */
    public function updateOrderStatus(MpesaTopUpTransaction $transaction, bool $success): void
    {
        $query = Order::query();

        if (str_starts_with($transaction->reference_id, 'S')) {
            $query->where('stk_order_no', $transaction->reference_id);
        } else {
            $query->where('order_no', $transaction->reference_id);
        }

        $query->where('status', Order::STATUS_PENDING_PAYMENT);

        $order =$query->first();

        if (!$order) {
            return;
        }

        if ($order && $success == true) {
            $order->status =  Order::STATUS_PENDING_SERVICE;
            $order->paid = $order->paid + $transaction->amount;
            $order->save();

            PaymentValidated::dispatch($order);
        } else {
            $order->status =  Order::STATUS_PAYMENT_FAILED;
            $order->save();
        }
    }

    /**
     * /////////////////////////////////////////////////
     * Mpesa validation blocks.
     */////////////////////////////////////////////////

    /**
     * Callback for payment validation.
     *
     * @param Request $request
     *
     * @return void
     */
    public function paymentValidation(Request $request)
    {
        if ($request->get('secret') == null || ($request->get('secret') && Hash::check('22rembeka20', $request->get('secret')) !== true)) {
            return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => 'Rejected',
            ]);
        }

        $data = $request->all();

        if (preg_match('/[R|r](0|O|o)/', $data['BillRefNumber'])) {
            return $this->validateOrderReference($data);
        }

        if (preg_match('/^[Cc]\d*[0-9](\/)\d*([0-1])\d*([1-9])(\/)([0-9]{2})/', $data['BillRefNumber'])) {
            return $this->validateCorporateAccount($data);
        }

        if (is_numeric($data['BillRefNumber'])) {
            return $this->validateOrderByPhone($data);
        }

        // this will by default accept an STK push validation.

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }

    /**
     * validate order by phone number.
     *
     * @param array $data
     *
     * @return void
     */
    public function validateOrderByPhone(array $data)
    {
        $phone = substr($data['BillRefNumber'], -9);
        $account = User::where('phone', 'LIKE', '%'.$phone)
            ->where('status', User::STATUS_ACTIVE)
            ->with(['orders' => function ($query) {
                $query->latest()->first();
            }])
            ->get();

        if (! $account || $account == null || $account->count() < 1 || $account->first()->orders->first()->balance < 1) {
            return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => 'Rejected',
            ]);
        }

        $this->initializeAccountCtoBDeposits($data, $account->first(), $account->first()->orders->first());

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }

    /**
     * Validate order by order number.
     *
     * @param array $data
     *
     * @return void
     */
    public function validateOrderReference(array $data)
    {
        $orderNumber = 'RO'.substr($data['BillRefNumber'], -(strlen($data['BillRefNumber']) - 2));

        $order = Order::Where('order_no', $orderNumber)
            ->with(['customer'])
            ->first();

        if ($order && $order->balance > 0) {
            $this->initializeAccountCtoBDeposits($data, $order->customer, $order);

            return response()->json([
                    'ResultCode' => 0,
                    'ResultDesc' => 'Accepted',
                ]);
        }

        return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => 'Rejected',
            ]);
    }

    /**
     * Handle business payment from none akiba account in mpesa.
     *
     * @return void
     */
    private function initializeAccountCtoBDeposits(array $data, User $account, $order = null): void
    {
        $data = (object) $data;

        MpesactobDeposit::create([
            'trans_id' => $data->TransID,
            'trans_time' => $data->TransTime,
            'user_id' => $account->id,
            'amount' => $data->TransAmount,
            'mpesa_transaction_type' => $data->TransactionType,
            'bill_ref_no' => $data->BillRefNumber,
            'business_short_code' => $data->BusinessShortCode,
            'invoice_number' => $order->order_no ?? null,
            'order_id' => $order->id ?? null,
            'org_account_balance' => $data->OrgAccountBalance,
            'third_party_trans_id' => $data->ThirdPartyTransID,
            'phone' => $data->MSISDN,
            'first_name' => $data->FirstName ?? null,
            'middle_name' => $data->MiddleName?? null,
            'last_name' => $data->LastName ?? null,
        ]);
    }

    /**
     * Transaction successful confirmation call back.
     *
     * @param Request $request
     *
     * @return void
     */
    public function paymentConfirmation(Request $request): void
    {
        if ($request->get('secret') == null || ($request->get('secret') && Hash::check('22rembeka20', $request->get('secret')) !== true)) {
            return;
        }

        if ($this->isAnSTKPushConfirmation($request)) {
            return;
        }

        $data = $request->all();

        $payment = MpesactobDeposit::where('trans_id', $data['TransID'])
            ->where('phone', $data['MSISDN'])
            ->where('status', MpesactobDeposit::STATUS_PENDING)
            ->with(['user', 'order'])
            ->first();

        if (! $payment || $payment == null) {
            return;
        }

        if (preg_match('/^[Cc]\d*[0-9](\/)\d*([0-1])\d*([1-9])(\/)([0-9]{2})/', $payment->bill_ref_no)) {
            $this->updateCorporateWallet($payment);

            return;
        }

        if ($payment->order) {
            $overPayment = $data['TransAmount'] - $payment->order->balance;
            $paidAmount = 0;
            $balance = 0;

            if ($overPayment > 0) {
                $paidAmount = $payment->order->balance;
                DB::transaction(function () use ($payment, $overPayment) {
                    $this->creditWalletWithOverpayment($payment->order, $overPayment);
                });
                $payment->order->over_paid = 1;
            } else {
                $balance = $payment->order->balance - $data['TransAmount'];
                $paidAmount =  $data['TransAmount'];
            }

            $payment->order->balance = $balance;
            $payment->order->paid = $payment->order->paid + $paidAmount;

            $payment->order->status = $payment->order->status == Order::STATUS_PENDING_PAYMENT ?
                Order::STATUS_ORDER_CONFIRMED :
                $payment->order->status;

            $payment->order->save();

            $payment->status = MpesactobDeposit::STATUS_CONFIRMED;
            $payment->save();

            if ($balance < 1) {
                OrderItem::where('order_id', $payment->order->id)
                    ->update(['status' => OrderItem::STATUS_COMPLETED]);
            }

            MpesaBalance::where('id', 1)->update([
                'mpesa_c2b' => $data['OrgAccountBalance'],
            ]);
        }

        if ($payment->user) {
            $message =  'Hi '.$payment->user->first_name.', Payment for order '.$payment->order_no.' amount Ksh '.  $data['TransAmount'].' made. Pending Balance is Ksh '.$balance.' .Thank you for choosing Rembeka';
            $payment->user->notify(new SmsNotification($message));
        }
    }

    /**
     * Credit wallet with overpayment.
     *
     * @param Order  $order
     * @param [type] $overPaymentAmount
     *
     * @return void
     */
    public function creditWalletWithOverpayment(Order $order, $overPaymentAmount): void
    {
        $user = User::where('id', $order->user_id)
            ->lockForUpdate()
            ->first();
        $previousAmount = $user->wallet;

        $user->wallet += $overPaymentAmount;
        $user->save();

        $description = 'Rembeka Points worth Ksh.'.$overPaymentAmount.' Credited to wallet as a result of overpayment of order '.$order->order_no;

        makeAudit(
            $order->user_id,
            'App\Models\User',
            $description,
            WalletAudit::CREDIT,
            $order->user_id,
            $overPaymentAmount,
            $previousAmount,
        );
    }

    /**
     * Handle STK push Validations.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function isAnSTKPushConfirmation($request): bool
    {
        $data = $request->all();

        if (isset($data['Body']) && $data['Body']['stkCallback'] && $data['Body']['stkCallback']['ResultCode'] == 0) {
            $data['BillRefNumber'] = $data['Body']['stkCallback']['CheckoutRequestID'];
            DB::transaction(function () use ($data) {
                $transaction = MpesaTopUpTransaction::where('checkout_request_id', $data['BillRefNumber'])
                    ->where('status', MpesaTopUpTransaction::STATUS_PENDING)
                    ->lockForUpdate()
                    ->first();
                if ($transaction && str_starts_with($transaction->reference_id, 'ST')) {
                    $this->stkPushCheckoutConfirmation($transaction, $data);
                }

                if ($transaction && str_starts_with($transaction->reference_id, 'RP')) {
                    $this->handleWalletTopUp($transaction, $data);
                }
            });

            return true;
        }

        return false;
    }

    /**
     * confirm stk push payment on order.
     *
     * @param array $data
     *
     * @return void
     */
    public function stkPushCheckoutConfirmation($transaction, array $data)
    {
        $transaction->status = MpesaTopUpTransaction::STATUS_ACCEPTED;
        $transaction->save();

        $order = Order::findorFail($transaction->order_id);

        $order->status = $order->status == Order::STATUS_PENDING_PAYMENT ?
            Order::STATUS_ORDER_CONFIRMED :
            $order->status;

        $order->paid += $transaction->amount;
        $order->balance -= $transaction->amount;
        $order->save();

        if (isset($data['OrgAccountBalance'])) {
            MpesaBalance::where('id', 1)->update([
                'mpesa_c2b' => $data['OrgAccountBalance'],
            ]);
        }
    }

    /**
     * Wallet top up.
     *
     * @param array $data
     *
     * @return void
     */
    public function handleWalletTopUp($transaction, array $data)
    {
        $userId = $transaction->user_id;

        $user =  User::where('id', $userId)->first();

        $previousAmount = $user->wallet;

        $user->wallet += $transaction->amount;
        $user->save();

        $description = 'Purchase of rembeka points worth Ksh '.$transaction->amount;
        WalletAudit::create([
            'user_id' =>$userId,
            'auditable_id' => $userId,
            'auditable_type' => 'App\Models\User',
            'description' => $description,
            'amount' => $transaction->amount,
            'previous_balance' => $previousAmount,
            'effect_type' => WalletAudit::CREDIT,
        ]);

        $transaction->status = MpesaTopUpTransaction::STATUS_ACCEPTED;
        $transaction->save();
    }

    /**
     * @return void
     */
    public function validateCorporateAccount($data)
    {
        $user =  User::where('account_no', $data['BillRefNumber'])->first();

        if ($user) {
            $this->initializeAccountCtoBDeposits($data, $user);

            return response()->json([
                'ResultCode' => 0,
                'ResultDesc' => 'Accepted',
            ]);
        }

        return response()->json([
            'ResultCode' => 1,
            'ResultDesc' => 'Rejected',
        ]);
    }

    /**
     * Update Corporate Wallet.
     *
     * @return void
     */
    public function updateCorporateWallet(MpesactobDeposit $payment)
    {
        $previousBalance = $payment->user->wallet;

        User::where('id', $payment->user_id)->update([
            'wallet' => $payment->user->wallet + $payment->amount
        ]);

        $payment->status = MpesactobDeposit::STATUS_CONFIRMED;
        $payment->save();

        $description = 'Account top up from mpesa for amount Ksh. '.number_format($payment->amount, 2);
        makeAudit(
            $payment->user->id,
            'App\Models\User',
            $description,
            WalletAudit::CREDIT,
            $payment->user->id,
            $payment->amount,
            $previousBalance,
        );
    }
    
    /**
     * validate C2B payments
     *
     * @param [type] $string
     * @return void
     */
    public function validateCtoBTransaction($string)
    {

        if (MpesactobDeposit::where('trans_id', $string)->exists()) {
            return response()->json([
                'message' => [
                    'type' => 'error',
                    'message' => 'Transaction already exists',
                ]
            ]);
        }

        $payload = [
            "Initiator" => config('mpesa.accounts.production.initiator'),
            "SecurityCredential" => $this->setSecurityCredentials(),
            "CommandID" => "TransactionStatusQuery",
            "TransactionID" => $string,
            "PartyA" => config('mpesa.accounts.production.lnmo.paybill'),
            "IdentifierType" => 4,
            "ResultURL" => config('app.url')."/status/callback", // config('mpesa.production.callback'), //"http://myservice:8080/transactionstatus/result",
            "QueueTimeOutURL" => config('app.url')."/status/callback",
            "Remarks" => "OK",
            "Occasion" => "OK",
        ];
        $curl = curl_init('https://api.safaricom.co.ke/mpesa/transactionstatus/v1/query');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getDefaultHeader());
        $response = curl_exec($curl);
        curl_close($curl);

        return response()->json([
            'message' => [
                'type' => 'success',
                'message' => 'request made',
            ]
        ]);
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
            'Authorization: Bearer '.$this->generateToken(),
        ];
    }

        /**
     * generate the security credentials security key.
     *
     * @return self::class
     */
    public function setSecurityCredentials()
    {
        $config = Config::get('btoc');

        $publicKey = file_get_contents(storage_path().'/'.$config['prod_cert_file']);
        $password = 'Qwerty@123!';

        \openssl_public_encrypt($password, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        return \base64_encode($encrypted);
    }


        /**
     * Generate access token.
     *
     * @return string
     */
    public function generateToken():string
    {
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode(config('mpesa.accounts.production.key').':'.config('mpesa.accounts.production.secret'));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic '.$credentials]); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        try {
            $response = json_decode(curl_exec($curl));
        } catch (Exception $e) {
        } finally {
            curl_close($curl);
        }

        return $response->access_token;
    }
}
