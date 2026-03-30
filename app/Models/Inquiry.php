<?php

namespace App\Models;

use App\Http\Requests\InquiryFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_CONVERTED = 1;
    const STATUS_DROPPED = 2;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'channel_id', 'description', 'callback_date' ,
        'user_id', 'social_name', 'product_id', 'status', 'assigned_id',
    ];

    protected $casts = [
        'callback_date' =>  'date',
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
        return InquiryFormRequest::class;
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
    public function channel():BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return BelongsTo
     */
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasMany
     */
    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }
}
