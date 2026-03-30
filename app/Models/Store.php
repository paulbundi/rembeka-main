<?php

namespace App\Models;

use App\Http\Requests\StoreFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name', 'location', 'commission', 'user_id',
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
        return StoreFormRequest::class;
    }

    /**
     * Manager.
     *
     * @return void
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
