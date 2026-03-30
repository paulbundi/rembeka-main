<?php

namespace App\Models;

use App\Http\Requests\ChannelFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name', 'description', 'status',
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
        return ChannelFormRequest::class;
    }

    /**
     * Orders
     *
     * @return void
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
