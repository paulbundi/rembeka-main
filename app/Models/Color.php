<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'hex_code',
        'display_type',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Color $color) {
            if (empty($color->slug) && !empty($color->name)) {
                $color->slug = strtolower(str_replace([' ', '/', '#'], ['-', '-', ''], $color->name));
            }
            if (empty($color->display_type)) {
                $color->display_type = $color->hex_code ? 'swatch' : 'pill';
            }
        });
    }

    protected static function getApiResourceClass(): string
    {
        return \App\Http\Resources\BaseResource::class;
    }

    protected static function getFormRequestClass(): string
    {
        return \App\Http\Requests\ColorFormRequest::class;
    }

    /**
      * @return HasMany
      */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'color_id');
    }

    /**
      * @return BelongsToMany
      */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_color', 'color_id', 'product_id');
    }

    public function getBackgroundColorAttribute(): string
    {
        return $this->hex_code ?? '#ccc';
    }

    /**
     * Check if this color has a visual swatch or is text-only.
     */
    public function isSwatch(): bool
    {
        return $this->display_type === 'swatch' && !empty($this->hex_code);
    }
}