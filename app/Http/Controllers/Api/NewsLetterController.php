<?php

namespace App\Http\Controllers\Api;

use App\Models\NewsLetterSubscription;

class NewsLetterController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return NewsLetterSubscription::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user',
        ];
    }
}
