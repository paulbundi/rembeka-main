<?php

namespace App\Repository\Users;

use App\Models\Channel;
use App\Models\Inquiry;
use App\Models\MpesaBalance;
use App\Models\NewsLetterSubscription;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPricing;
use App\Models\Provider;
use App\Models\ProviderInquiry;
use App\Models\SearchTerm;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminUserRepository
{
    /**
     * Dashboard data.
     *
     * @return array
     */
    public function dashboard(): array
    {
        $orders = Order::where('status', '!=', Order::STATUS_CANCELED)
            ->groupBy('store_id')
            ->select(DB::raw('store_id,count(id) as orders'))
            ->get();

        //sum of orders plus discount given(basically un-discounted order values)
        $orderSum = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', '!=', Order::STATUS_CANCELED)
            ->groupBy('store_id')
            ->select(DB::raw('store_id, sum(order_items.amount + order_items.discount_amount) as total'))
            ->get(); 

        /**
         * Basically amount paid to us!
         * should be less than above since,
         *  1. its paid after discount
         *  2. The above does not considers orders that are not paid just total value of the order so long as its not cancelled.
         */

        $collectionSum = Order::where('status', '!=', Order::STATUS_CANCELED)->sum('paid');
        

        $orderByChannel = Channel::with(['orders' => function ($query) {
            return $query ->groupBy('channel_id')
            ->groupBy('store_id')
            ->select(DB::raw('channel_id,store_id, sum(amount) as total'));
        }])->get();

        $inquiryByChannels = Inquiry::join('products', 'products.id', '=', 'inquiries.product_id')
            ->selectRaw('inquiries.channel_id, sum(products.cost_of_labour) total')
            ->groupBy('channel_id')
            ->with(['channel'])
            ->get();

        $inquries = Inquiry::count();

        $providerWallet =  User::where('account_type', User::TYPE_PROVIDER)->sum('wallet');
        $supplierWallet = User::where('account_type', User::TYPE_SUPPLIER)->sum('wallet');
        $userWallet =  User::where('account_type', User::TYPE_USER)->sum('wallet');
        $corporateWallet =  User::where('account_type', User::TYPE_CORPORATE)->sum('wallet');

        $providers = Provider::count();
        $providerInquries= ProviderInquiry::count();
        $userCount = User::where('account_type', User::TYPE_USER)->count();
        $corporates =  User::where('account_type', User::TYPE_CORPORATE)->count();

        $searchTearms = SearchTerm::with(['user'])->latest()->paginate(50);

        $subscription =  NewsLetterSubscription::count();

        $fullfieldOrders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FULFILLED])
            ->count();

        $sumOfFullfieldOrders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FULFILLED])
            ->sum('paid');

        $services = Product::where('type', Product::TYPE_SERVICE)->count();
        $products = ProductPricing::count();

        $mpesaBalances =  MpesaBalance::first();

        $dashboard = [
            'collectionSum' => $collectionSum,
            'corporates' => $corporates,
            'corporateWallet' => $corporateWallet,
            'fullfieldOrders' => $fullfieldOrders,
            'inquiryByChannels' => $inquiryByChannels,
            'inquries' => $inquries,
            'mpesaBalances' => $mpesaBalances,
            'newsLetterSubscriptions' => $subscription,
            'orderByChannel' => $orderByChannel,
            'orders' => $orders,
            'orderSum' => $orderSum,
            'products' => $products,
            'providerInquries' => $providerInquries,
            'providers' => $providers,
            'providerWallet' => $providerWallet,
            'supplierWallet' => $supplierWallet,
            'searchTearms' => $searchTearms,
            'services' => $services,
            'sumOfFullfieldOrders' => $sumOfFullfieldOrders,
            'userCount' => $userCount,
            'userWallet' => $userWallet,
        ];

        return $dashboard;
    }


    /**
     * admin product dashboard.
     */
    public function productDashboard()
    {
        $orders = Order::where('orders.status', '!=', Order::STATUS_CANCELED)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.type', OrderItem::TYPE_PRODUCT)
            ->groupBy('store_id')
            ->select(DB::raw('store_id,count(orders.id) as orders'))
            ->get();

                   
        $orderSum = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', '!=', Order::STATUS_CANCELED)
            ->where('order_items.type', OrderItem::TYPE_PRODUCT)
            ->groupBy('store_id')
            ->select(DB::raw('store_id, sum(order_items.amount) as total'))
            ->get(); 


        /**
         * So basically if an order is fully paid, get the sum of the products paid for in that order.
         */            
        $collectionSum = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.type', OrderItem::TYPE_PRODUCT)
            ->where('orders.status', '!=', Order::STATUS_CANCELED)
            ->where('orders.balance', '<', 1)
            ->sum('order_items.amount');


        $orderByChannel = Channel::with(['orders' => function ($query) {
            $query->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('type', OrderItem::TYPE_PRODUCT)
                ->groupBy('orders.channel_id', 'orders.store_id')
                ->selectRaw('orders.channel_id, orders.store_id, SUM(order_items.amount) as total');
        }])->get();

        $inquiryByChannels = Inquiry::join('product_pricings','product_pricings.product_id','=','inquiries.product_id')
            ->join('products','product_pricings.product_id','=','products.id')
            ->where('products.type', Product::TYPE_PRODUCT)
            ->selectRaw('inquiries.channel_id, sum(product_pricings.amount) total')
            ->groupBy('channel_id')
            ->with(['channel'])
            ->get();

        $inquries = Inquiry::
            join('products','products.id','=','inquiries.product_id')
            ->where('products.type', Product::TYPE_PRODUCT)
            ->count();

        $supplierWallet =  User::where('account_type', User::TYPE_SUPPLIER)->sum('wallet');
        $suppliers = User::where('account_type', User::TYPE_SUPPLIER)->count();
        $users = Order::whereHas('items', function($qry) {
            $qry->where('type', OrderItem::TYPE_PRODUCT);
        })
        ->groupBy('user_id')->get()->count();

        $fullfieldOrders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FULFILLED])
            ->count();

        $sumOfFullfieldOrders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FULFILLED])
            ->sum('paid');

        $products = ProductPricing::count();

        $topTwentyByVolume = OrderItem::with('product')
            ->where('type', OrderItem::TYPE_PRODUCT)
            ->groupBy('product_id')
            ->select(DB::raw('SUM(quantity) as qty, product_id'))
            ->orderByDesc('qty')
            ->limit(20)
            ->get();

        $topTenByValue = OrderItem::with('product')
            ->where('type', OrderItem::TYPE_PRODUCT)
            ->groupBy('product_id')
            ->select(DB::raw('SUM(amount) as amount, product_id')) 
            ->orderByDesc('amount')
            ->limit(10)
            ->get();


        $dashboard = [
            'collectionSum' => $collectionSum,
            'fullfieldOrders' => $fullfieldOrders,
            'inquiryByChannels' => $inquiryByChannels,
            'inquries' => $inquries,
            'orderByChannel' => $orderByChannel,
            'orders' => $orders,
            'orderSum' => $orderSum,
            'products' => $products,
            'suppliers' => $suppliers,
            'supplierWallet' => $supplierWallet,
            'sumOfFullfieldOrders' => $sumOfFullfieldOrders,
            'users' => $users,
            'topTwentyByVolume' => $topTwentyByVolume,
            'topTenByValue' => $topTenByValue,
        ];

    return $dashboard;
    }

    /**
     * admin Service dashboard.
     */
    public function serviceDashboard()
    {
        $orders = Order::where('orders.status', '!=', Order::STATUS_CANCELED)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.type', OrderItem::TYPE_SERVICE)
            ->groupBy('store_id')
            ->select(DB::raw('store_id,count(orders.id + order_items.discount_amount) as orders'))
            ->get();

       
        //sum of orders plus discount(basically un-discounted order values)
        $orderSum = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', '!=', Order::STATUS_CANCELED)
            ->where('order_items.type', OrderItem::TYPE_SERVICE)
            ->groupBy('store_id')
            ->select(DB::raw('store_id, sum(order_items.amount + order_items.discount_amount) as total'))
            ->get(); 


        /**
         * So basically if an order is fully paid, get the sum of the service paid for in that order.
         * 
         */            
        $collectionSum = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.type', OrderItem::TYPE_SERVICE)
            ->where('orders.status', '!=', Order::STATUS_CANCELED)
            ->where('orders.balance', '<', 1)
            ->sum('order_items.amount');
            
        $orderByChannel = Channel::with(['orders' => function ($query) {
            $query->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('type', OrderItem::TYPE_SERVICE)
                ->groupBy('orders.channel_id', 'orders.store_id')
                ->selectRaw('orders.channel_id, orders.store_id, SUM(order_items.amount) as total');
        }])->get();

        $inquiryByChannels = Inquiry::join('products','inquiries.product_id','=','products.id')
            ->where('products.type', Product::TYPE_SERVICE)
            ->selectRaw('inquiries.channel_id, sum(final_price) total')
            ->groupBy('channel_id')
            ->with(['channel'])
            ->get();

        $inquries = Inquiry::
            join('products','products.id','=','inquiries.product_id')
            ->where('products.type', Product::TYPE_SERVICE)
            ->count();

        $providersWallet =  User::where('account_type', User::TYPE_PROVIDER)->sum('wallet');
        $providers = User::where('account_type', User::TYPE_PROVIDER)->count();
        $users = Order::whereHas('items', function($qry) {
            $qry->where('type', OrderItem::TYPE_SERVICE);
        })
        ->groupBy('user_id')->get()->count();


        $fullfieldOrders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FULFILLED])
            ->count();

        $sumOfFullfieldOrders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FULFILLED])
            ->sum('paid');

        $services = Product::where('type', Product::TYPE_SERVICE)->count();

        $topTwentyByVolume = OrderItem::with('product')
            ->where('type', OrderItem::TYPE_SERVICE)
            ->groupBy('product_id')
            ->select(DB::raw('SUM(quantity) as qty, product_id'))
            ->orderByDesc('qty')
            ->limit(20)
            ->get();

        $topTenByValue = OrderItem::with('product')
            ->where('type', OrderItem::TYPE_SERVICE)
            ->groupBy('product_id')
            ->select(DB::raw('SUM(amount) as amount, product_id')) 
            ->orderByDesc('amount')
            ->limit(10)
            ->get();


        $dashboard = [
            'collectionSum' => $collectionSum,
            'fullfieldOrders' => $fullfieldOrders,
            'inquiryByChannels' => $inquiryByChannels,
            'inquries' => $inquries,
            'orderByChannel' => $orderByChannel,
            'orders' => $orders,
            'orderSum' => $orderSum,
            'services' => $services,
            'providers' => $providers,
            'providersWallet' => $providersWallet,
            'sumOfFullfieldOrders' => $sumOfFullfieldOrders,
            'users' => $users,
            'topTwentyByVolume' => $topTwentyByVolume,
            'topTenByValue' => $topTenByValue,
        ];

    return $dashboard;
    }

    /**
     * Filter with dashboard.
     *
     * @param array $filters
     *
     * @return void
     */
    public function revenueAnalytics(array $filters = [])
    {
        $filterStartAt = null;
        $filterEndAt = null;

        if ($filters && count($filters) > 0) {
            $filterStartAt = $filters['start_at'];
            $filterEndAt = $filters['end_at'].' 23:59';
        }

        //TODO:: take care of deleted orders.
        $serviceRevenue = OrderItem::where('provider_paid', 1)
            ->where('type', OrderItem::TYPE_SERVICE)
            ->selectRaw('sum(amount) as amount, sum(provider_amount) as provider_amount, sum(discount_amount) as discount')
            ->when($filterStartAt, function ($query) use ($filterStartAt, $filterEndAt) {
                return $query->whereBetween('created_at', [$filterStartAt, $filterEndAt]);
            })
            ->get();


        $productRevenue = OrderItem::where('provider_paid', 1)
            ->where('type', OrderItem::TYPE_PRODUCT)
            ->selectRaw('sum(amount) as amount, sum(provider_amount) as provider_amount, sum(discount_amount) as discount')
            ->when($filterStartAt, function ($query) use ($filterStartAt, $filterEndAt) {
                return $query->whereBetween('created_at', [$filterStartAt, $filterEndAt]);
            })
            ->get();

        $homeCallRevenue = OrderItem::where('provider_paid', 1)
            ->whereHas('order', function ($query) {
                return $query->whereNull('store_id');
            })
            ->selectRaw('sum(amount) as amount, sum(provider_amount) as provider_amount, sum(discount_amount) as discount')
            ->when($filterStartAt, function ($query) use ($filterStartAt, $filterEndAt) {
                return $query->whereBetween('created_at', [$filterStartAt, $filterEndAt]);
            })
            ->get();

        $franchiseRevenue = OrderItem::where('provider_paid', 1)
            ->whereHas('order', function ($query) {
                return $query->whereNotNull('store_id');
            })
            ->selectRaw('sum(amount) as amount, sum(provider_amount) as provider_amount, sum(discount_amount) as discount')
            ->when($filterStartAt, function ($query) use ($filterStartAt, $filterEndAt) {
                return $query->whereBetween('created_at', [$filterStartAt, $filterEndAt]);
            })
            ->get();

        return [
            'serviceRevenue' => $serviceRevenue,
            'productRevenue' => $productRevenue,
            'homeCallRevenue' => $homeCallRevenue,
            'franchiseRevenue' => $franchiseRevenue,
        ];
    }
}
