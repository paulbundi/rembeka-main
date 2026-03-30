<?php

namespace App\Http\Controllers;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:brands.view')->only('index');
        $this->middleware('can-access:brands.create')->only('create');
        $this->middleware('can-access:brands.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'brands-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'brands-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'brands-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'brands-create', 'id' => $id]);
    }
}
