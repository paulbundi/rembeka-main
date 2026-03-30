<?php

namespace App\Models;

use App\Http\Requests\WalletTopUpFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTopUp extends Model
{
    use HasFactory;

    const CHEQUE = 1;
    const MPESA = 2;
    const BANK_DEPOSIT = 3;

    protected $fillable = [
        'user_id', 'corporate_id', 'description', 'amount', 'transaction_no', 'payment_mode',

    ];

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getApiResourceClass(): string
    {
        return BaseResource::class;
    }

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getFormRequestClass(): string
    {
        return WalletTopUpFormRequest::class;
    }
}
