<?php

namespace App\Models;

use App\Http\Requests\BestSellerFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // /**
    //  * @return BelongsTo
    //  */
    // public function providerPricing(): BelongsTo
    // {
    //     return $this->belongsTo(ProviderPricing::class);
    // }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'provider_pricing_id');
    }
}
