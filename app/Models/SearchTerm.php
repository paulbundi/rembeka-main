<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchTerm extends Model
{
    use HasFactory;

    //TODO: status shld define if a lead was created, products keyword updated etc.
    protected $fillable = [
        'user_id', 'search_term', 'status', 'results', 'hits',
    ];

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
