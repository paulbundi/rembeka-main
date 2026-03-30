<?php

namespace App\Models;

use App\Http\Resources\MpesaDepositResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MpesaTopUpTransaction extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_HAS_ISSUE = 4;
    const STATUS_ISSUE_RESOLVED = 5;

    protected $fillable = [
        'user_id', 'amount', 'status', 'trans_id', 'transaction_number', 'trans_time', 'merchant_request_id',
        'checkout_request_id', 'response_code', 'response_description', 'customer_message', 'reference_id',
        'active_phone_number', 'order_id',
    ];

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getApiResourceClass(): string
    {
        return MpesaDepositResource::class;
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

    /**
     * @return BelongsTo
     */
    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
