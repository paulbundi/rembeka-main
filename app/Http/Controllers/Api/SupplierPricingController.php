<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductPricing;
use App\Models\SupplierInvoice;
use Illuminate\Http\Request;

class SupplierPricingController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return ProductPricing::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'supplier', 'product', 'product.discount', 'unit', 'category'
        ];
    }

    /**
     * Create a new Record.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'productPricing' => 'required',
        ]);

        foreach ($data['productPricing'] as $pricing) {
            $pricing['product_id'] = $data['product_id'];
            $pricing['supplier_id'] = $data['supplier_id'];
            ProductPricing::create($pricing);
        }

        return $this->getModelResource()
            ->toResponse($request)
            ->setStatusCode(201);
    }

    /**
     * Supplier Receive Products.
     *
     * @return void
     */
    public function receiveProducts(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->id();

        $ivoiceItems = [];
        foreach ($data['items'] as $item) {
            $productPricing = ProductPricing::where('id', $item['id'])
                ->where('supplier_id', $data['supplier_id'])
                ->with(['product'])
                ->first();

            if ($productPricing) {
                $available = $productPricing->instock;
                $productPricing->instock = $available + $item['newStock'];
                $productPricing->save();

                array_push($ivoiceItems, [
                    'product' => $productPricing->product->name,
                    'size' => $productPricing->size,
                    'listed_price' => $productPricing->supplier_price,
                    'amount' => $productPricing->amount,
                    'available' => $productPricing->instock,
                    'new_supply' =>  $item['newStock'],
                ]);
            }
        }

        $data['items'] = $ivoiceItems;

        SupplierInvoice::create($data);

        return response()->json([]);
    }
}
