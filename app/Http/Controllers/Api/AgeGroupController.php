<?php

namespace App\Http\Controllers\Api;

use App\Models\AgeGroup;

class AgeGroupController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return AgeGroup::class;
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
