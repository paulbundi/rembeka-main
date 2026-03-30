<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;

class LocationController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Location::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()->whereNull('parent_id');
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'children', 'children.children', 'children.children.children',
            'children.children.children.children'
        ];
    }
}
