<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;

class MenuController extends AbstractApiController
{
    public function __construct()
    {
        $this->middleware('can-access:menus.delete')->only('destroy');
    }

    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Menu::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users',
            'children',
            'children.children',
            'children.children.children',
            'children.children.children.children'
        ];
    }

    /**
     * Get the allowed counts.
     *
     * @return array
     */
    protected function getAllowedCounts(): array
    {
        return [
            'products',
            'children.products'
        ];
    }
}
