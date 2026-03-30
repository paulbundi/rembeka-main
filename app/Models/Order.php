<?php

namespace App\Models;

use App\Http\Requests\OrderFormRequest;
use App\Http\Resources\BaseResource;
use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, ScopedFilter;

    const STATUS_PENDING_PAYMENT = 1;
    const STATUS_PAYMENT_FAILED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_ORDER_CONFIRMED = 4;//julie
    const STATUS_PENDING_SERVICE = 5;
    const STATUS_PARTIAL_DELIVERY = 6;
    const STATUS_FULFILLED = 7;//service delivered
    const STATUS_PARTIAL_RATING = 8;//multiple services
    const STATUS_COMPLETED = 9;
    const STATUS_WAITING_CONFIRMATION = 10;

    const INITIALIZED_REFUND = 1;
    const REFUNDED = 2;

    const DEPOSIT_PERCENTAGE_ON_SERVICES = 50;

    const DRIVER_PAID = 1;

    // 'amount'  => total Order value,
    // 'paid' => deposit,
    // 'balance' => balance,

    protected $fillable = [
        'order_no', 'stk_order_no', 'user_id', 'amount', 'paid', 'balance', 'over_paid', 'notes', 'status',
        'location_id', 'channel_id', 'cancel_reason', 'refund_status', 'otp', 'inquiry_id', 'admin_id', 'address_id',
        'has_transport_cost', 'transport_cost', 'delivery_amount', 'store_id', 'driver_id','driver_paid',
        'payment_on_delivery','referral_code_id', 'referral_discount',
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
        return OrderFormRequest::class;
    }

    /**
     * @return HasMany
     */
    public function items():HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * User who created the order.
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * @return HasMany
     */
    public function transportRequests(): HasMany
    {
        return $this->hasMany(TransportRequest::class);
    }

    /**
     * @return HasMany
     */
    public function deliveryRequests(): HasMany
    {
        return $this->hasMany(DeliveryRequest::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }


    /**
     * Order Address
     *
     * @return void
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

        /**
     *
     * @return BelongsTo
     */
    public function referralCode(): BelongsTo
    {
        return $this->belongsTo(Referralcode::class, 'referral_code_id', 'id');
    }


    
}
