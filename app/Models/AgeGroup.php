<?php

namespace App\Models;

use App\Http\Requests\AgeGroupFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name', 'description', 'status', 'show_on_menu', 'menu_name'
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
        return AgeGroupFormRequest::class;
    }
}
