<?php

namespace App\Models;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WalletAudit extends Model
{
    use HasFactory;

    const DEBIT = 1;
    const CREDIT = 2;

    protected $fillable = [
        'auditable_id', 'auditable_type', 'description', 'effect_type', 'user_id', 'previous_balance',
        'amount', 'order_id',
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
        return '';
    }

    /**
     * @return MorphTo
     */
    public function auditable():MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
