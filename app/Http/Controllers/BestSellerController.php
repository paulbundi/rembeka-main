<?php

namespace App\Http\Controllers;

class BestSellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:services.view')->only('index');
        $this->middleware('can-access:products.create')->only('create');
        $this->middleware('can-access:products.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'best-sellers-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'best-sellers-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'best-sellers-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'best-sellers-create', 'id' => $id]);
    }
}
