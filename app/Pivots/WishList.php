<?php

namespace App\Pivots;

use App\Http\Resources\BaseResource;
use App\Models\Product;
use App\Models\User;
use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class WishList extends Pivot
{
    use ScopedFilter;

    protected $table = 'wish_list';

    public $incrementing = true;

    /**
     * get wishlist products
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * get wishlist products
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return '';
    }
}
