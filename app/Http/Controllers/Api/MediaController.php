<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;

class MediaController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Media::class;
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
