<?php

namespace App\Models;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaystackPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'reference', 'transaction_id', 'amount', 
        'currency', 'status', 'authorization_url', 'access_code', 'meta', 'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'meta' => 'json',
    ];

    protected static function getApiResourceClass(): string
    {
        return BaseResource::class;
    }

    protected static function getFormRequestClass(): string
    {
        return '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}