<?php

namespace App\Models;

use App\Http\Requests\CategoryFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//define hair, make up etc. , men women children etc. -> closely related to menus.
class Category extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name', 'description', 'parent_id', 'status', 'position',
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
        return CategoryFormRequest::class;
    }

    /**
     * @return void
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
