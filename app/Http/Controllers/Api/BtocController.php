<?php

namespace App\Http\Controllers\Api;

use App\Helpers\WithdrawCharges;
use App\Models\MpesaBTCTransaction;
use App\Models\User;
use App\Models\WalletAudit;

class BtocController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return MpesaBTCTransaction::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user',
        ];
    }

    /**
     * Reverse transaction.
     *
     * @param int $id
     *
     * @return void
     */
    public function reverseTransaction(int $id)
    {
        $transaction = MpesaBTCTransaction::with(['user'])
            ->where('status', '!=', MpesaBTCTransaction::REVERSED)
            ->findOrFail($id);
        $amount = $transaction->amount + WithdrawCharges::getCharge($transaction->amount);

        $previousBalance = $transaction->user->wallet;

        User::where('id', $transaction->user_id)->update([
            'wallet' => $transaction->user->wallet + $amount
        ]);

        $transaction->status = MpesaBTCTransaction::REVERSED;
        $transaction->save();

        $description = 'Reversal of wallet withdraw of amount Ksh. '.number_format($amount, 2);
        makeAudit(
            $transaction->user_id,
            'App\Models\User',
            $description,
            WalletAudit::CREDIT,
            auth()->id(),
            $amount,
            $previousBalance,
        );
    }
}
