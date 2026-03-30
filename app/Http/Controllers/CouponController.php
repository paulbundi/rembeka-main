<?php

namespace App\Http\Controllers;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:coupons.view')->only('index');
        $this->middleware('can-access:coupons.create')->only('create');
        $this->middleware('can-access:coupons.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'coupons-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'coupons-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'coupons-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'coupons-show', 'id' => $id]);
    }
}
