<?php

namespace App\Providers;

use App\Models\Advert;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\User;
use App\ViewComposer\Ecommerce;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.dashboard', function ($view) {
            $store = [];
            $store['authUser'] = Auth::user()->toArray();
            $view->with('store', json_encode($store));
        });

        View::composer(['layouts.e-commerce', 'layouts.e-commerce-footer'], function ($view) {
            $menus = Menu::active()
            ->with(['children.children.children.children'])
            ->whereNull('parent_id')
            ->get();

            $view->with('menus', $menus);
        });

        View::composer('layouts.e-commerce', function ($view) {
            $orders = 0;
            if (auth()->check() && auth()->user()->account_type == User::TYPE_PROVIDER) {
                $orders = OrderItem::where('provider_id', auth()->user()->organization_id)
                    ->count();
            }
            $view->with('orderItems', $orders);
        });

        View::composer('layouts.e-commerce', Ecommerce::class);

        View::composer('e-commerce.welcome', function ($view) {
            $activeAd = Advert::with(['attachments.media'])
                ->inRandomOrder()
                ->where('type', Advert::TYPE_MODAL)
                ->where('status', Advert::STATUS_ACTIVE)
                ->first();
            $view->with('activeAd', $activeAd);
        });
    }
}
