<?php

namespace App\Http\Controllers\Api;

use App\Models\SupplierInvoice;

class SupplierInvoiceController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return SupplierInvoice::class;
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
