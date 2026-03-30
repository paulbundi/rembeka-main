<?php

namespace App\Http\Controllers;

class DeliveryRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:delivery-requests.view')->only('index');
        $this->middleware('can-access:delivery-requests.create')->only('create');
        $this->middleware('can-access:delivery-requests.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'delivery-request-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'delivery-request-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'delivery-request-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'delivery-request-show', 'id' => $id]);
    }
}
