<?php

namespace App\Http\Controllers\Api;

use App\Models\SmsCampaign;

class SmsCampaignController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return SmsCampaign::class;
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
