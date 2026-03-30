<?php

namespace App\Models;

use App\Http\Requests\ProviderPricingFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderPricing extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;

    const SERVICE_TYPE_HOME = 1;
    const SERVICE_TYPE_SALON = 2;

    /*
    *commission
    * defines what percentage rembeka retains.
    */

    /*
    *provider_cost
    * stylist take home cost_of_labour - commission.
    */

    /*
    *Amount
    * shows the final price on platform after round-up.
    */

    /*
     * service_pricing
     * Final Pricing before round up.
     */

    protected $fillable = [
        'product_id', 'category_id', 'service_location', 'commission' , 'provider_id', 'location_id',
        'cost_of_labour', 'provider_cost', 'service_pricing', 'amount', 'status',
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
        return ProviderPricingFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
