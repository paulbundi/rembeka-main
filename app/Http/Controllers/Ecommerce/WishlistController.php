<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Pivots\WishList;

class WishlistController extends Controller
{
    /**
     * @return void
     */
    public function wishlist()
    {
        $wishlist = WishList::where('user_id', auth()->id())
            ->with([
                'product.attachments.media',
                'product.discount',
            ])
            ->paginate();

        return view('e-commerce.account.wishlist', [
            'wishlists' => $wishlist
        ]);
    }

    /**
     * Add to wish list
     *
     * @param string $slug
     *
     * @return void
     */
    public function addWishList(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        auth()->user()->wishlist()->syncWithoutDetaching($product->id);

        return redirect()->back()
                ->with([
                    'message' =>[
                        'type' => 'success',
                        'message' => 'Item added to wishlist',
                    ],
            ]);
    }

    /**
     * remove from wishlist
     *
     * @param string $slug
     *
     * @return void
     */
    public function removeFromWishList(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        auth()->user()->wishlist()->detach($product->id);

        return redirect()->back();// TODO clean up
    }
}
