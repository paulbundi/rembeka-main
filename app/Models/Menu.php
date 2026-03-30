<?php

namespace App\Models;

use App\Http\Requests\MenuFormRequest;
use App\Http\Resources\BaseResource;
use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, ScopedFilter;

    const STATUS_ACTIVE = 1;

    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 2;

    protected $fillable = [
        'name', 'description', 'type', 'parent_id', 'status', 'position', 'icon'
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
        return MenuFormRequest::class;
    }

    /**
     * @return void
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
