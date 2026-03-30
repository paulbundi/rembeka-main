<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class SaleController extends AbstractApiController
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
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()
            ->whereHas('items', function ($query) {
                return $query->where('type', Product::TYPE_PRODUCT);
            });
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'location', 'items.supplier', 'customer', 'items.provider', 'items.product', 'items.category', 'items',
            'channel', 'admin', 'store','address', 'driver',
        ];
    }
}
