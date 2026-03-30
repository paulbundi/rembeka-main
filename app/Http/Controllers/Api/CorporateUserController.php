<?php

namespace App\Http\Controllers\Api;

use App\Models\CorporateUser;

class CorporateUserController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return CorporateUser::class;
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
