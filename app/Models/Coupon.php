<?php

namespace App\Models;

use App\Http\Requests\CouponFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'is_percent',
        'value',
        'free_shipping',
        'start_date',
        'end_date',
        'is_active',
        'minimum_spend',
        'maximum_spend',
        'usage_limit_per_coupon',
        'usage_limit_per_customer',
        'assigned_user_id',
        'user_id',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'free_shipping' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date', 'deleted_at'];

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
        return CouponFormRequest::class;
    }

    /**
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function valid()
    {
        if ($this->hasStartDate() && $this->hasEndDate()) {
            return $this->startDateIsValid() && $this->endDateIsValid();
        }

        if ($this->hasStartDate()) {
            return $this->startDateIsValid();
        }

        if ($this->hasEndDate()) {
            return $this->endDateIsValid();
        }

        return true;
    }

    public function invalid()
    {
        return ! $this->valid();
    }

    private function hasStartDate()
    {
        return ! is_null($this->start_date);
    }

    private function hasEndDate()
    {
        return ! is_null($this->end_date);
    }

    private function startDateIsValid()
    {
        return today() >= $this->start_date;
    }

    private function endDateIsValid()
    {
        return today() <= $this->end_date;
    }
}
