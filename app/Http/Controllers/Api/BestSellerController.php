<?php

namespace App\Http\Controllers\Api;

use App\Models\BestSeller;

class BestSellerController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return BestSeller::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'product', 'product.attachments.media'
        ];
    }
}
