<?php

namespace App\Models;

use App\Http\Requests\ProductPricingFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPricing extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    /**
     **listing_amount  ->amount before round up
     */

    /**
     **amount  ->amount after round up
     */
    protected $fillable = [
        'product_id', 'supplier_id', 'size', 'unit_id', 'supplier_price', 'mark_up_percentage', 'listing_amount',
        'amount', 'instock', 're_order_level', 'configs', 'status',
    ];

    protected $casts = [
        'configs' => 'array',
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
        return  ProductPricingFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
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
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitMeasure::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
