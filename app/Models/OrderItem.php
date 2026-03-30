<?php

namespace App\Models;

use App\Http\Requests\OrderItemRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;

    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 2;

    const PROVIDER_PAID = 1;

    const DISCOUNTED = 0;

    protected $fillable = [
        'order_id', 'product_id', 'category_id', 'provider_id', 'quantity', 'provider_amount',
        'provider_discount', 'percentage_commission', 'amount', 'discounted', 'discount_amount',
        'appointment_date', 'appointment_time', 'provider_paid', 'beneficiary', 'type', 'status',
        'pricing_id','service_pricing','provider_cost','provider_discount_amount','rembeka_discount_amount',
        'rembeka_discount', 'un_discounted_commission', 'total_discount','shared_commission','assisting_provider_id',
    ];

    protected $casts = [
        'beneficiary' => 'array',
        'shared_commission' => 'array',
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
        return OrderItemRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
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
    public function assistingProvider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'assisting_provider_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'provider_id');
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
