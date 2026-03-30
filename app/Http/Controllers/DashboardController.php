<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Repository\Providers\ProviderRepository;
use App\Repository\Users\AdminUserRepository;

class DashboardController extends Controller
{
    /**
     * dashboard index.
     *
     * @return void
     */
    public function index()
    {
        if (auth()->user()->account_type == User::TYPE_ADMIN) {
            $dashboard = (new AdminUserRepository())->dashboard();

            return view('dashboard.admin-dashboard', $dashboard);
        }

        if (auth()->user()->account_type == User::TYPE_CORPORATE) {
            $orders = Order::mine()->count();

            return view('dashboard.corporate.dashboard', ['orders' => $orders]);
        }

        if (auth()->user()->account_type == User::TYPE_DRIVER) {

            return redirect()->route('profile.index');
        }


        $dashboard = (new ProviderRepository())->dashboard(auth()->user()->organization_id);

        return view('dashboard.provider-dashboard', $dashboard);
    }

    /**
     * Product dashboard
     *
     * @return void
     */
    public function productDashboard()
    {
        $dashboard = (new AdminUserRepository())->productDashboard();
        return view('dashboard.products-admin-dashboard', $dashboard);
        
    }


    /**
     * Product dashboard
     *
     * @return void
     */
    public function serviceDashboard()
    {
        $dashboard = (new AdminUserRepository())->serviceDashboard();
        return view('dashboard.service-admin-dashboard', $dashboard);
        
    }
}
