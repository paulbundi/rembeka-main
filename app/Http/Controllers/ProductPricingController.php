<?php

namespace App\Http\Controllers;

class ProductPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:suppliers.view')->only('index');
        $this->middleware('can-access:suppliers.create')->only('create');
        $this->middleware('can-access:suppliers.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'supplier-pricing-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'supplier-pricing-create']);
    }

    /**
     * @return void
     */
    public function show($id)
    {
        return view('dashboard.page', ['page' => 'supplier-pricing-show', 'id' => $id]);
    }

    /**
     * @return void
     */
    public function edit($id)
    {
        return view('dashboard.page', ['page' => 'supplier-pricing-create', 'id' => $id]);
    }
}
