<?php

namespace App\Models;

use App\Http\Requests\PartnerFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name', 'description', 'user_id', 'status', 'callback_url', 'media_id',
    ];

    /**
     * Get the api resource.
     *
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
        return PartnerFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function logo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
