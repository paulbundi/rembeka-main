<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\Partner;
use App\Models\PdqPayment;
use Illuminate\Http\Request;

class PdqPaymentController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return PdqPayment::class;
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
