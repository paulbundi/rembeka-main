<?php

namespace App\Http\Controllers\Api;

use App\Models\ProviderInquiry;

class ProviderInquiryController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return ProviderInquiry::class;
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
