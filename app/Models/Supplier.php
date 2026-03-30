<?php

namespace App\Models;

use App\Http\Requests\SupplierFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_INDIVIDUAL = 1;
    const TYPE_COMPANY = 2;

    const STATUS_ACTIVE = 1;
    const DEFAULT_RATING = 5;

    protected $fillable = [
        'first_name', 'last_name', 'name', 'user_id', 'email', 'phone', 'national_id', 'kra_pin', 'address',
        'slug', 'description', 'type', 'status', 'rating', 'address',
    ];

    protected $appends = [
        'displayName',
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
        return SupplierFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set name to help with remote filters.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->type == self::TYPE_INDIVIDUAL) {
            return $this->first_name.' '.$this->last_name;
        }

        return $this->name;
    }
}
