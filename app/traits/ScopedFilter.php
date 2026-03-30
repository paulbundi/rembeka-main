<?php

namespace App\traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * active record
 */
trait ScopedFilter
{
    /**
     * get active record
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeActive(Builder $builder):Builder
    {
        return $builder->where('status', self::STATUS_ACTIVE);
    }

    /**
     * get my records.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeMine(Builder $builder):Builder
    {
        return $builder->where('user_id', auth()->id());
    }
}
