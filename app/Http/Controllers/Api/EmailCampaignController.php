<?php

namespace App\Http\Controllers\Api;

use App\Models\EmailCampaign;

class EmailCampaignController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return EmailCampaign::class;
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
