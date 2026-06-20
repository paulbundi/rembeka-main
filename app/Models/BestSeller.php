<?php

namespace App\Models;

use App\Http\Requests\BestSellerFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class BestSeller extends Model
{
    use HasFactory;

    protected $fillable =[
        'provider_pricing_id',
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
        return BestSellerFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function providerPricing(): BelongsTo
    {
        return $this->belongsTo(ProviderPricing::class);
    }

    /**
     * @return HasOneThrough
     */
    public function product(): HasOneThrough
    {
        return $this->hasOneThrough(
            Product::class,
            ProviderPricing::class,
            'id',
            'id',
            'provider_pricing_id',
            'product_id'
        );
    }
}
