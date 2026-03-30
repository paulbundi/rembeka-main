<?php

namespace App\Models;

use App\Http\Requests\InquiryActivityFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryActivity extends Model
{
    use HasFactory;

    const ACTIVITY_CALL = 1;
    const ACTIVITY_SMS = 2;
    const ACTIVITY_WHATSAPP = 3;
    const ACTIVITY_SOCIAL_MEDIA = 4;
    const ACTIVITY_ASSIGNMENT_CHANGED = 5;

    protected $fillable = [
        'user_id', 'inquiry_id', 'activity', 'title', 'description', 'acivity_link'
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
        return InquiryActivityFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
