<?php

namespace App\Models;

use App\Http\Resources\MpesaWithDrawResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MpesaBTCTransaction extends Model
{
    const INITIATED = 1;
    const CONFIRMED = 2;
    const FAILED = 3;
    const CANCELLED = 4;
    const REVERSED = 5;

    protected $fillable =[
        'user_id', 'transaction_time', 'amount', 'bill_reference_number', 'organisation_account_balance',
        'transaction_id', 'transaction_response', 'conversation_id', 'originator_conversation_id',
        'transaction_receipt', 'error_code', 'error_message', 'status',
    ];

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getApiResourceClass(): string
    {
        return MpesaWithDrawResource::class;
    }

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getFormRequestClass(): string
    {
        return '';
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
