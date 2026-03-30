<?php

namespace App\Models;

use App\Http\Requests\ProviderProfileFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProviderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id', 'professional_qualifications', 'works_experience'
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
        return ProviderProfileFormRequest::class;
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * @return MorphMany
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
