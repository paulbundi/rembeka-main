<?php

namespace App\Http\Controllers\Api;

use App\Models\UnitMeasure;

class UnitMeasureController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return UnitMeasure::class;
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
