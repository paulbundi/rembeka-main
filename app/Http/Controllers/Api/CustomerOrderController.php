<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;

class CustomerOrderController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Order::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'items.provider', 'items.product', 'items.category', 'channel', 'admin',
            'items.supplier', 'store',
        ];
    }
}
