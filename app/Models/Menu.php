<?php

namespace App\Models;

use App\Http\Requests\MenuFormRequest;
use App\Http\Resources\BaseResource;
use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, ScopedFilter;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($menu) {
            $menu->children()->get()->each(function ($child) {
                $child->delete();
            });
            // Force delete products to avoid FK constraint violation,
            // since Product uses SoftDeletes and a soft delete would
            // leave the rows in the database referencing this menu.
            $menu->products()->forceDelete();
        });
    }

    const STATUS_ACTIVE = 1;

    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 2;

    protected $fillable = [
        'name',
        'description',
        'type',
        'parent_id',
        'status',
        'position',
        'icon'
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
        return MenuFormRequest::class;
    }

    /**
     * @return void
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * Get products associated with this menu.
     *
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
