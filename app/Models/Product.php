<?php

namespace App\Models;

use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;

    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 2;
    const TYPE_PACKAGE = 3;

    const PLATFORM_FEE = 100;
    const PROVIDER_TRANSPORT_COST = 300;


    /**
     * Publish product to the e-commerce front-end
     */
    const IS_PUBLISHED = 1;

    /*
    *cost_of_labour
    * provider priving before commission.
    */

    /*
    *provider_cost
    * stylist take home cost_of_labour - commission.
    */

    /*
     * product_price
     * Final Pricing before round-up.
     */

    /*
     * final_price
     * Final Pricing after round up. Price to be inherited to provider.
     */

    protected $fillable = [
        'slug', 'name', 'sku', 'description', 'keywords', 'seo_title', 'seo_description',
        'status', 'menu_id', 'type', 'product_used', 'duration_of_style', 'durability',
        'cost_of_labour', 'provider_cost', 'commission', 'constant_commission', 'platform_fee',
        'product_price', 'final_price', 'category_id', 'brand_id', 'is_published'
    ];

    /**
     * Define slug route name.
     *
     * @return void
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
        return ProductFormRequest::class;
    }

    /**
     * @return void
     */
    public function clean()
    {
        return Arr::except(
            $this->toArray(),
            [
                'description', 'keywords', 'seo_title', 'seo_description',
                'status',
            ]
        );
    }

    //TODO: refactor supplierPrice && productPrice names

    /**
     * Provider Pricing
     *
     * @return BelongsToMany
     */
    public function productPrice(): BelongsToMany
    {
        return $this->belongsToMany(ProviderPricing::class, 'provider_pricings');
    }

    /**
     *  Supplier Pricing.
     * TODO:: refactor to allow multiple supplier same item.
     *
     * @return HasMany
     */
    public function supplierPrice(): HasMany
    {
        return $this->hasMany(ProductPricing::class);
    }

    /**
     * @return MorphMany
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * @return void
     */
    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_product', 'product_id', 'related_id');
    }

    /**
     * @return BelongsToMany
     */
    public function ageGroups(): BelongsToMany
    {
        return $this->belongsToMany(AgeGroup::class, 'age_group_product');
    }

    /**
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return void
     */
    public function discount()
    {
        return $this->hasOne(Discounted::class);
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->BelongsTo(Brand::class);
    }

    /**
     * This is necessary not to break discounted products,
     * Its just enables view specific product from the discounted slide.
     * NB:// this is not ideal
     *
     * @return void
     */
    public function lastestProviderPricing():HasOne
    {
        return $this->hasOne(ProviderPricing::class);
    }

    /**
     * Get running advert.
     *
     * @return HasOne
     */
    public function advert(): HasOne
    {
        return $this->hasOne(Advert::class);
    }
}
