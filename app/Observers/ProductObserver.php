<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProviderPricing;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Listen for creating new product event.
     *
     * @param Product $product
     *
     * @return void
     */
    public function created(Product $product)
    {
        $product->slug = Str::slug($product->name.'-'.$product->id);

        if ($product->type == PRODUCT::TYPE_SERVICE) {
            $product->platform_fee = Product::PLATFORM_FEE;
            $product->provider_cost = $product->cost_of_labour * ((100 - $product->commission)/100);
        }

        $product->save();
    }

    /**
     * Remove deleted Product from provider pricing.
     *
     * @param Product $product
     *
     * @return void
     */
    public function deleted(Product $product)
    {
        ProviderPricing::where('product_id', $product->id)->delete();
    }
}
