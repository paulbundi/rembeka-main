<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;

class MerchandiseController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Product::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [

        ];
    }
}
