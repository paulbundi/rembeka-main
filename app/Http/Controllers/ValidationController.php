<?php

namespace App\Http\Controllers;

use App\Models\MpesaBalance;
use App\Models\MpesaBTCTransaction;
use App\Models\MpesactobDeposit;
use App\Repository\Payment\MpesaValidationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ValidationController extends Controller
{
    /**
     * Validate Mpesa payment request.
     *
     * @param Request                   $request
     * @param MpesaValidationRepository $repo
     *
     * @return void
     */
    public function paymentValidation(Request $request, MpesaValidationRepository $repo)
    {
        return $repo->paymentValidation($request);
    }

    /**
     * Transaction Confirmation.
     *
     * @param Request                   $request
     * @param MpesaValidationRepository $repo
     *
     * @return void
     */
    public function paymentConfirmation(Request $request, MpesaValidationRepository $repo)
    {
        return $repo->paymentConfirmation($request);
    }

    /**
     * Transaction results.
     *
     * @param Request $request
     *
     * @return void
     */
    public function paymentResult(Request $request)
    {
        $response = (object) $request->Result;

        sleep(2);

        if (isset($response->ResultCode) && $response->ResultCode == 0) {
            $transaction = MpesaBTCTransaction::where('conversation_id', $response->ConversationID)
                ->where('status', MpesaBTCTransaction::INITIATED)
                ->first();
            if (! $transaction || $transaction == null) {
                return;
            }
            $transaction->status = MpesaBTCTransaction::CONFIRMED;
            $transaction->error_message = $response->ResultDesc;
            $transaction->transaction_receipt = $response->TransactionID;
            $transaction->transaction_response = json_encode($response->ResultParameters ?? []);
            $transaction->save();

            foreach ($response->ResultParameters['ResultParameter'] as $results) {
                if ($results['Key'] ==  'B2CUtilityAccountAvailableFunds') {
                    MpesaBalance::where('id', 1)->update([
                        'mpesa_b2c' => $results['Value'],
                    ]);
                }
            }
        } else {
            $transaction = MpesaBTCTransaction::where('conversation_id', $response->ConversationID)
                ->update([
                    'status' =>  MpesaBTCTransaction::FAILED,
                    'transaction_receipt' => $response->TransactionID,
                    'error_code' => $response->ResultCode,
                    'error_message' => $response->ResultDesc,
                ]);
        }
    }

    /**
     * C2B validation callback
     *
     * @param Request $request
     * @return void
     */
    public function statusCallback(Request $request)
    {

        $data = $request->all();

        \Log::info('validating c2b status callback------');
        \Log::info(print_r($data, true));
        \Log::info('-----end callback ----');

        if ($data['Result'] && $data['Result']['ResultCode'] != 0) {
            return;
        }

        $responseData['third_party_trans_id'] = $data['Result']['ConversationID'];
        $responseData['user_id'] = 1;
        $responseData['status'] = MpesactobDeposit::STATUS_CONFIRMED;

        foreach ($data['Result']['ResultParameters']['ResultParameter'] as $item) {

            if ($item['Key'] == 'DebitPartyName') {
                $responseData['first_name'] = $item['Value'];
                $payerDetails = explode('-', $item['Value']);
                if (count($payerDetails) > 0) {
                    $responseData['phone'] = $payerDetails[0];
                    $responseData['first_name'] = $payerDetails[1];
                }
            }
            if ($item['Key'] == 'InitiatedTime') {
                $responseData['trans_time'] = $item['Value'];
            }
            if ($item['Key'] == 'Amount') {
                $responseData['amount'] = $item['Value'];
            }
            if ($item['Key'] == 'ReceiptNo') {
                $responseData['trans_id'] = $item['Value'];
            }
        }

        if(Cache::get($responseData['trans_id'])) {
            $responseData['user_id'] = Cache::get($responseData['trans_id']);
        }


        MpesactobDeposit::create($responseData);
    }

    public function transactionTimeout(Request $request)
    {
        Log::info('----------timeout--------');
        Log::info(print_r($request->all(), true));
        Log::info('----------timeout--------');
    }

    /**
     * Confirmation request.
     *
     * @param Request $request
     *
     * @return void
     */
    public function invalidStK(Request $request): void
    {
        \Log::info(print_r($request->all(), true));
    }
}
