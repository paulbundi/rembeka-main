<?php

namespace App\Http\Controllers\Api;

use App\Pivots\WishList;

class WishlistController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return WishList::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'product', 'product.attachments.media'
        ];
    }
}
