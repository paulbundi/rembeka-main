<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Provider;
use App\Models\ProviderPricing;

class ProductController extends Controller
{
    /**
     * @param string $slug
     * @param int    $id
     *
     * @return void
     */
    public function show(string $slug, int $productId, int $providerId = null)
    {

        $product = Product::where('id', $productId)
            ->with(['attachments.media', 'menu', 'discount', 'supplierPrice.unit', 'advert'])
            ->first();


        $reviews = ProductReview::where('product_id', $productId)
            ->where('is_visible', '!=', 0)
            ->with(['user'])
            ->paginate();

        $stylist = null;
        if ($providerId) {
            $stylist = Provider::findOrFail($providerId);
        }
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->whereHas('menu', function ($query) use ($product) {
                $query->where('menu_id', $product->menu_id);
            })->when($product->type == Product::TYPE_PRODUCT, function ($query) {
                $query->with('supplierPrice');
            })->with(['attachments.media', 'discount'])
            ->limit(20)
            ->get();

        return view('e-commerce.products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'relatedProducts' => $relatedProducts,
            'provider' => $stylist,
        ]);
    }

    /**
     * Provider specific product.
     *
     * @param int $bookMyService
     *
     * @return void
     */
    public function bookMyService($providerPricingId)
    {
        $productPricing = ProviderPricing::where('id', $providerPricingId)
            ->with(['product.attachments.media', 'provider.profile'])
            ->first();
        $reviews = ProductReview::where('provider_pricing_id', $providerPricingId)
            ->with(['user'])
            ->paginate();

        $relatedProducts = ProviderPricing::whereHas('product', function ($query) use ($productPricing) {
            $query->where('menu_id', $productPricing->product->menu_id);
        })->limit(20)
        ->get();


        return view('e-commerce.products.show', [
            'productPricing' => $productPricing,
            'reviews' => $reviews,
            'relatedProducts' => $relatedProducts,
            'providerSelected' => 1,
            // 'product' => $relatedProducts? $relatedProducts->first()->product: [],
            // 'provider' => $productPricing->provider,
        ]);
    }

    /**
     * Hidden Treasure
     *
     * @return void
     */
    public function hiddenTreasure()
    {
        return view('e-commerce.products.hidden-trasure');
    }
}
