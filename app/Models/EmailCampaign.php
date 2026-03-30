<?php

namespace App\Models;

use App\Http\Requests\EmailCampaignFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailCampaign extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_INDIVIDUAL = 1;
    const TYPE_GROUP = 2;

    protected $fillable = [
        'group_id', 'user_id', 'sender_id', 'type', 'subject', 'message', 'sent',
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
        return EmailCampaignFormRequest::class;
    }
}
