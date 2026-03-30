<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFormRequest;
use App\Http\Requests\ProductReviewFormRequest;
use App\Models\ProductReview;
use App\Models\ProviderPricing;

class ProductReviewController extends Controller
{
    /**
     * @param AddressFormRequest $request
     *
     * @return void
     */
    public function store(ProductReviewFormRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        // $product = ProviderPricing::where('id', $data['provider_pricing_id'])
        //     ->firstOrFail();
        // $data['product_id'] = $product->product_id;
        // $data['provider_id'] = $product->provider_id;

        ProductReview::create($data);

        return redirect()->back();
    }
}
