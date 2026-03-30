<?php

namespace App\Http\Controllers\Api;

use App\Models\Discounted;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountedController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Discounted::class;
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
        $request = $this->getRequest();
        $this->preStore($request);
        $this->model->fill($request->only(array_keys($request->rules())));
        $product =  Product::where('id', $request->product_id)->first();

        $this->model->product_price = $product->final_price;
        $this->model->payable =  (($product->final_price - 100) * ((100 - $request->discount_amount)/ 100)) + 100;

        $this->model->save();
        $this->postStore($request);

        return $this->getModelResource()
            ->toResponse($request)
            ->setStatusCode(201);
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'product', 'product.menu', 'product.attachments.media'
        ];
    }
}
