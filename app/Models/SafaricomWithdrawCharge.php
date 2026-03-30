<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafaricomWithdrawCharge extends Model
{
    use HasFactory;

    const TRANSACTION_SUCCESSFUL = 1;
    const TRANSACTION_FAILED = 2;

    protected $fillable = [
        'user_id', 'transaction_id', 'mpesa_withdraw_id', 'withdrawing_amount', 'transaction_cost', 'status',
    ];
}
