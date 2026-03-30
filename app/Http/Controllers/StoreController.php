<?php

namespace App\Http\Controllers;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:stores.view')->only('index');
        $this->middleware('can-access:stores.create')->only('store');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'store-index']);
    }

    public function create()
    {
        return view('dashboard.page', ['page' => 'store-create']);
    }
}
