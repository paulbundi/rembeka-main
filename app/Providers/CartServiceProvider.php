<?php

namespace App\Providers;

use App\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            Cart::class, function ($app) {
                return new Cart(
                    $app['session'],
                    $app['events'],
                    'cart',
                    session()->getId(),
                    config('shopping_cart')
                );
            }
        );

        $this->app->alias(Cart::class, 'cart');
    }
}
