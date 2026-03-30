<?php

namespace App\Models;

use App\Http\Requests\SmsCampaignFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsCampaign extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_INDIVIDUAL = 1;
    const TYPE_GROUP = 2;

    protected $fillable = [
        'group_id', 'user_id', 'sender_id', 'type', 'message', 'sent',
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
        return SmsCampaignFormRequest::class;
    }

    /**
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
