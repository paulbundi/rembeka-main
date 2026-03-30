<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;

class StoreController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Store::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'manager',
        ];
    }
}
