<?php

namespace App\Models;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdqPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'card_number', 'receipt_id', 'order_id', 'amount',
    ];



    /**
     * Get the api resource.
     *
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
     *
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
