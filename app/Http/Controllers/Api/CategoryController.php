<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;

class CategoryController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Category::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users', 'children', 'children.children', 'children.children.children',
            'children.children.children.children'
        ];
    }
}
