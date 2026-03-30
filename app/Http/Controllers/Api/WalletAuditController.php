<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\WalletAudit;
use Illuminate\Http\Request;

class WalletAuditController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return WalletAudit::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'auditable'
        ];
    }

    public function accountTransfer(Request $request)
    {
        $data = $this->validate($request, [
            'amount' => 'required',
            'description' => 'required',
            'giving_account'=> 'required|integer',
            'receiving_account' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $fromAccount = User::where('id', $data['giving_account'])->firstOrFail();

        $receivingAccount = User::where('id', $data['receiving_account'])->firstOrFail();

        if  ($fromAccount->id == $receivingAccount->id) {
            return response()->json(['errors' => [
                'messages' => ['Wueh! You seem to have upset the internal use of the house!']
            ]], 422);
        }

        if ($fromAccount->wallet < $data['amount']) {
            return response()->json(['errors' => [
                'messages' => ['Amount transferred is more than available amount!']
            ]], 422);
        }

        $previousBalance = $fromAccount->wallet;
        $fromAccount->wallet -= $data['amount'];
        $fromAccount->save();

        $description = 'Wallet transfer of amount. '.number_format($data['amount'], 2).' to '.$receivingAccount->name.' --- '.$data['description'];
        makeAudit(
            $fromAccount->id,
            'App\Models\User',
            $description,
            WalletAudit::CREDIT,
            auth()->id(),
            $data['amount'],
            $previousBalance,
        );

        $runningBalance = $receivingAccount->wallet;
        $receivingAccount->wallet += $data['amount'];
        $receivingAccount->save();

        $description = 'Wallet transfer of amount. '.number_format($data['amount'], 2).' from '.$fromAccount->name .' --- '.$data['description'];
        makeAudit(
            $receivingAccount->id,
            'App\Models\User',
            $description,
            WalletAudit::DEBIT,
            auth()->id(),
            $data['amount'],
            $runningBalance,
        );

        return response()->json([], 200);
    }
}
