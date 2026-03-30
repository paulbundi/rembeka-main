<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;

class BookingController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Booking::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'provider', 'providerPricing.product'
        ];
    }
}
