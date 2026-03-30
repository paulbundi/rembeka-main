<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\WalletAudit;
use App\Models\WalletTopUp;
use Illuminate\Http\Request;

class WalletTopUpController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return WalletTopUp::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $corporeate = User::findOrFail($this->model->corporate_id);

        $previousBalance = $corporeate->wallet;

        $corporeate->wallet += $this->model->amount;
        $corporeate->save();
        $description = 'Wallet topup of Ksh '.$this->model->amount. ' transaction reference'. $this->model->transaction_no;

        makeAudit(
            $corporeate->id,
            'App\Models\User',
            $description,
            WalletAudit::CREDIT,
            auth()->id(),
            $this->model->amount,
            $previousBalance,
        );
    }
}
