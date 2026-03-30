<?php

namespace App\Models;

use App\Http\Requests\DiscountedFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discounted extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_FIXED = 1;
    const TYPE_PERCENTAGE = 2;

    protected $fillable = [
        'product_id', 'discount_type', 'discount_amount', 'product_price', 'payable',
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
        return DiscountedFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
