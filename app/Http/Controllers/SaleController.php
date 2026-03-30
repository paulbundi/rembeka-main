<?php

namespace App\Http\Controllers;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:sales.view')->only('index');
        $this->middleware('can-access:sales.create')->only('create');
        $this->middleware('can-access:sales.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'sales-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'sales-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'sales-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'sales-show', 'id' => $id]);
    }
}
