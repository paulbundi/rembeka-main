<?php

namespace App\Models;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address',
         'services', 'professional_qualifications', 'works_experience', 'status',
    ];

    protected $casts = [
        'services' => 'array',
    ];

    protected $appends = [
        'serviceOffered',
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
        return ProviderInquiryFormRequest::class;
    }

    /**
     * @return void
     */
    public function getServiceOfferedAttribute()
    {
        $servicesList = '';

        if ($this->services && count($this->services)) {
            $menu = Menu::whereIn('id', $this->services)->get('name');
            if ($menu) {
                $menu->each(function ($item) use (&$servicesList) {
                    $servicesList = $servicesList .' '.$item->name.', ';
                });
            }
        }

        return $servicesList;
    }
}
