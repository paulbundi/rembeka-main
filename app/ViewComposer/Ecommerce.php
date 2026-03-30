<?php

namespace App\ViewComposer;

use App\Facades\Cart;
use Illuminate\View\View;

class Ecommerce
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $cart = Cart::toArray();

        $view->with('store', [
            'cart' => json_encode(['cart' => $cart]),
        ]);
    }
}
