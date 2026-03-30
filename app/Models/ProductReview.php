<?php

namespace App\Models;

use App\Http\Requests\ProductReviewFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'provider_pricing_id' , 'product_id', 'provider_id', 'rating', 'comment',
        'is_visible',
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
        return  ProductReviewFormRequest::class;
    }

    /**
     * User review
     *
     * @return void
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return void
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * User review
     *
     * @return void
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
