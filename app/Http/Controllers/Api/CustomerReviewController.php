<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductReview;

class CustomerReviewController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return ProductReview::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'product', 'provider'
        ];
    }
}
