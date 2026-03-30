<?php

namespace App\Models;

use App\Http\Requests\ReferralcodeFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Referralcode extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'code', 'description', 'referrer', 'user_id', 'acquisition_cost', 'status',
        'is_ambassador', 'referred_first_visit_discount', 'referred_second_visit_discount',
        'ambassador_discount', 'max_users', 'used_count',
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
        return ReferralcodeFormRequest::class;
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * @return void
     */
    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }



    /**
     * @return void
     */
    public function owner(): BelongsTo
    {
        return  $this->belongsTo(User::class, 'referrer', 'id');
    }
    
}
