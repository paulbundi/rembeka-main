<?php

namespace App\Http\Controllers;

use App\Repository\Users\AdminUserRepository;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:transactions.revenue')->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboard = (new AdminUserRepository())->revenueAnalytics();

        return view('dashboard.revenues.index', $dashboard);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dashboard = (new AdminUserRepository())->revenueAnalytics($request->all());

        $dashboard = array_merge($dashboard, $request->all());

        return view('dashboard.revenues.index', $dashboard);
    }
}
