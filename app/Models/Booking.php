<?php

namespace App\Models;

use App\Http\Requests\BookingFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_CONFIRMED = 1;

    protected $fillable = [
        'provider_id', 'user_id', 'service_id', 'franchise_id', 'confirmation_status', 'reminder_sent', 'slot_time',
    ];

    protected $casts = [
        'slot_time'  => 'datetime',
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
        return BookingFormRequest::class;
    }

    /**
     * Filter provider slots
     *
     * @param Builder $builder
     *
     * @return void
     */
    public function scopeMine(Builder $builder)
    {
        return  $builder->where('provider_id', auth()->user()->organization_id);
    }

    /**
     * provider service booked
     *
     * @return BelongsTo
     */
    public function providerPricing(): BelongsTo
    {
        return $this->belongsTo(ProviderPricing::class, 'service_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
