<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    use HasFactory;

    const PUBLISHABLE = 1;

    protected $fillable = [
        'rating', 'rateable_id', 'rateable_type', 'comment', 'user_id', 'publishable',
    ];

    /**
     * @return BelongsTo
     */
    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * commenting user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
