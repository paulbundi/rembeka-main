<?php

namespace App\Http\Controllers;

use App\Helpers\WithdrawCharges;
use App\Http\Requests\MpesaWithdrawalRequest;
use App\Http\Requests\WithdrawForProviderFormRequest;
use App\Mail\BtoCInsufficientFunds;
use App\Models\MpesaBTCTransaction;
use App\Models\SafaricomWithdrawCharge;
use App\Models\User;
use App\Models\WalletAudit;
use App\Repository\Payment\BtoCRepository;
use App\Repository\Payment\RequestMpesaPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * @param int $userId
     *
     * @return void
     */
    public function walletLog(int $userId)
    {
        $audits = WalletAudit::where('auditable_id', $userId)
            ->latest()
            ->paginate();

        return view('dashboard.transactions.wallet-audit', ['audits' => $audits]);
    }

    /**
     * Withdraw from wallet to mpesa.
     *
     * @param MpesaWithdrawalRequest $request
     *
     * @return void
     */
    public function withdrawToMpesa(MpesaWithdrawalRequest $request)
    {
        $data = $request->validated();
        
        $key = 'trans'. auth()->id();
        $value = Cache::get($key);

        if ($value) {
            return redirect()->route('profile.index')->with([
                'message' =>[
                    'type' => 'info',
                    'message' => 'A transaction is already in progress. Please wait for it to finish before trying again.',
                ],
            ]);
        }

        Cache::put($key, $data['amount'], $seconds = 60);

        DB::transaction(function () use ($data) {
            $user = User::lockForUpdate()->find(auth()->id());

            return $this->makeBtoCTransaction($data, $user);
        });

        return redirect()->route('profile.index')->with([
            'message' =>[
                'type' => 'success',
                'message' => 'Amount sent to mpesa successfully',
            ],
        ]);
    }

    /**
     * withdraw on behave of the agent/provider.
     *
     * @param MpesaWithdrawalRequest $request
     *
     * @return void
     */
    public function withdrawForProvider(WithdrawForProviderFormRequest $request)
    {
        $data =  $request->validated();

          
        $key = 'trans'.$data['user_id'];

        $value = Cache::get($key);


        if ($value) {
            return redirect()->route('stylist.income', $data['provider_id'])->with([
                'message' =>[
                    'type' => 'info',
                    'message' => 'A transaction is already in progress. Please wait for it to finish before trying again.',
                ],
            ]);
        }

        Cache::put($key, $data['amount'], $seconds = 60);


        DB::transaction(function () use ($data) {
            $user =  User::lockForUpdate()->findOrFail($data['user_id']);

            return $this->makeBtoCTransaction($data, $user);
        });

        return redirect()->route('stylist.income', $data['provider_id'])
            ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => 'Amount sent to Mpesa successfully',
                ],
            ]);
    }

    /**
     * Buy points.
     *
     * @param Request $request
     *
     * @return void
     */
    public function buyPoints(Request $request, RequestMpesaPayment $requestPayment)
    {
        $data =  $request->validate([
            'amount' => 'required',
        ]);

        $transaction = 'RP'.auth()->id();
        $response = $requestPayment->viaStkPush($data['amount'], $transaction);

        return redirect()->route('profile.index')->with($response);
    }

    /**
     * initiate c2b transaction.
     *
     * @param array $data
     * @param User  $user
     *
     * @return void
     */
    protected function makeBtoCTransaction(array $data, User $user)
    {
        $occasion = Str::uuid()->toString();
        $btocRepository = app(BtoCRepository::class);

        $response = json_decode($btocRepository->makeWithdraw($data['amount'], $user, $occasion));

        Log::info(print_r($response));
        
        if (isset($response->ResponseCode) && $response->ResponseCode == 0) {
            $data['status'] = MpesaBTCTransaction::INITIATED;
            $data['user_id'] = $user->id;
            $data['bill_reference_number'] = $occasion;
            $data['error_code'] = $response->ResponseCode;
            $data['error_message'] = $response->ResponseDescription ?? ($response->ResultDesc ?? 'success');
            $data['conversation_id'] = $response->ConversationID;
            $data['originator_conversation_id'] = $response->OriginatorConversationID;
            $data['transaction_id'] = $response->TransactionID ?? null;

            $transId = MpesaBTCTransaction::create($data)->id;
            $cost = WithdrawCharges::getCharge($data['amount']);

            SafaricomWithdrawCharge::create([
                'user_id' => $user->id,
                'mpesa_withdraw_id' => $transId,
                'withdrawing_amount' => $data['amount'],
                'transaction_cost' => $cost,
            ]);

            $amount = $data['amount'] + $cost;
            $previousAmount = $user->wallet;

            User::where('id', $user->id)->decrement('wallet', $amount);

            $description = "Withdraw Ksh {$data['amount']} from Wallet to Mpesa, transaction cost $cost.";
            WalletAudit::create([
                'user_id' => auth()->id(),
                'auditable_id' => $user->id,
                'auditable_type' => 'App\Models\User',
                'description' => $description,
                'amount' => $data['amount'],
                'previous_balance' => $previousAmount,
                'effect_type' => WalletAudit::DEBIT,
            ]);

            return redirect()->back()
                ->with([
                    'message' =>[
                        'type' => 'success',
                        'message' => 'Amount sent to mpesa successfully',
                    ],
            ]);
        }

        if (isset($response->ResultCode) && $response->ResultCode) {
            $data['status'] = MpesaBTCTransaction::INITIATED;
            $data['user_id'] = auth()->id();
            $data['bill_reference_number'] = $occasion;
            $data['error_code'] = $response->ResultCode;
            $data['error_message'] = $response->ResultDesc;
            $data['conversation_id'] = $response->ConversationID;
            $data['originator_conversation_id'] = $response->OriginatorConversationID;
            $data['transaction_id'] = $response->TransactionID ?? null;

            $this->createTransaction($data);

            if ($response->ResultCode == 5) {
                Mail::to(config()->get('rembeka')['insufficientFunds'])->send(new BtoCInsufficientFunds);
            }
        }

        return redirect()->back()
        ->with([
            'message' =>[
                'type' => 'error',
                'message' => 'An error occurred, tyr again later',
            ],
        ]);
    }

    /**
     * Create btoc transaction
     *
     * @return void
     */
    public function createTransaction($data):MpesaBTCTransaction
    {
        return MpesaBTCTransaction::create($data);
    }
}
