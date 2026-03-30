<?php

namespace App\Http\Controllers;

class ProviderPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:providers.view')->only('index');
        $this->middleware('can-access:providers.create')->only('create');
        $this->middleware('can-access:providers.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'provider-pricing-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'provider-pricing-create']);
    }

    /**
     * @return void
     */
    public function show($id)
    {
        return view('dashboard.page', ['page' => 'provider-pricing-show', 'id' => $id]);
    }

    /**
     * @return void
     */
    public function edit($id)
    {
        return view('dashboard.page', ['page' => 'provider-pricing-create', 'id' => $id]);
    }
}
