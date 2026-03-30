<?php

namespace App\Http\Controllers;

class ServiceDiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:discounts.view')->only('index');
        $this->middleware('can-access:discounts.create')->only('create');
        $this->middleware('can-access:discounts.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'service-discounts-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'service-discounts-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'service-discounts-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        // return view('dashboard.page', ['page' => 'service-discounts-show', 'id' => $id]);
        return view('dashboard.page', ['page' => 'service-discounts-create', 'id' => $id]);
    }
}
