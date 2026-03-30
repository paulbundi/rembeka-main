<?php

namespace App\Models;

use App\Http\Requests\DriverFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'user_id', 'email', 'phone', 'national_id',
        'description','status', 'rating', 'dl_no', 'dl_expiry_date'
    ];

    protected $appends = [
        'displayName',
    ];


    protected $casts = [
        'dl_expiry_date' => 'date',
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
        return DriverFormRequest::class;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
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
        return $this->first_name.' '.$this->last_name;
    }
}
