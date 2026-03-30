<?php

namespace App\Models;

use App\Http\Requests\ProviderFormRequest;
use App\Http\Resources\BaseResource;
use App\Pivots\LocationProvider;
use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Provider extends Model
{
    use HasFactory, Notifiable, ScopedFilter;

    const STATUS_ACTIVE = 1;

    const DEFAULT_RATING = 5;

    const PROVIDER_PUBLISHED = 1;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'status', 'rating',
        'national_id', 'kra_pin', 'address', 'slug', 'short_description',
        'published',
    ];

    protected $appends = [
        'name',
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
        return ProviderFormRequest::class;
    }

    /**
     * set fullnames.
     *
     * @return void
     */
    public function getNameAttribute()
    {
        return $this->first_name.' '. $this->last_name;
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(ProductProvider::class);
    }

    /**
     * @return HasMany
     */
    public function productPricings(): HasMany
    {
        return $this->hasMany(ProviderPricing::class);
    }

    /**
     * @return BelongsToMany
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class)
            ->using(LocationProvider::class)
            ->withTimestamps();
    }

    /**
     * @return HasOne
     */
    public function profile():HasOne
    {
        return $this->hasOne(ProviderProfile::class);
    }

    /**
     * @return HasOne
     */
    public function user():HasOne
    {
        return $this->hasOne(User::class, 'organization_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function works():HasMany
    {
        return $this->hasMany(ProviderWork::class);
    }

    /**
     * @return Builder
     */
    public function scopePublished(Builder $builder):Builder
    {
        return $builder->where('published', self::STATUS_ACTIVE);
    }

    /**
     * Orders Items
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
