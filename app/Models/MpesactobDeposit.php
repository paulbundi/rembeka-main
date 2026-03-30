<?php

namespace App\Models;

use App\Http\Resources\MpesaDepositResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MpesactobDeposit extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_CANCELLED = 3;

    protected $fillable = [
        'user_id', 'trans_id', 'trans_time', 'amount', 'mpesa_transaction_type', 'bill_ref_no',
        'business_short_code', 'invoice_number', 'org_account_balance', 'third_party_trans_id',
        'phone', 'first_name', 'middle_name', 'last_name', 'status', 'order_id',
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
