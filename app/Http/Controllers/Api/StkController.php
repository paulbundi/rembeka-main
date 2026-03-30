<?php

namespace App\Http\Controllers\Api;

use App\Models\MpesaTopUpTransaction;
use App\Repository\Payment\MpesaValidationRepository;

class StkController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return MpesaTopUpTransaction::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'order',
        ];
    }

    /**
     * Concfirm SKT payment request.
     *
     * @param int $id
     *
     * @return void
     */
    public function confirmPayment($transId, MpesaValidationRepository $repo)
    {
        $trans = MpesaTopUpTransaction::where('id', $transId)
        ->where('status', MpesaTopUpTransaction::STATUS_PENDING)
        ->first();
        if (! $trans) {
            return response()->json(['message' => 'Transaction not found'], 400);
        }

        return $repo->validateTopUp($transId);
    }
}
