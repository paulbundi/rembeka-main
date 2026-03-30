<?php

namespace App\Models;

use App\Http\Requests\AdvertFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;
    const TYPE_MODAL = 1;
    const TYPE_HUNT = 2;

    protected $fillable = ['name', 'call_to_action_url', 'call_to_action', 'type', 'product_id', 'status', 'audit'];

    protected $casts = [
        'audit' =>'array',
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
        return AdvertFormRequest::class;
    }

    /**
     * @return MorphMany
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Product here
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
