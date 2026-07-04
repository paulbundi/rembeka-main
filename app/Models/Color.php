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
    ];

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
}


