<?php

namespace App\Http\Controllers;

class ColorController extends Controller
{
    public function __construct()
    {
        // Colors are managed alongside products; reuse product permissions
        // so existing admin roles work without a role re-seed.
        $this->middleware('can-access:products.view')->only('index');
        $this->middleware('can-access:products.create')->only('create');
        $this->middleware('can-access:products.update')->only('edit');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'colors-index']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'colors-index']);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'colors-index', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'colors-index', 'id' => $id]);
    }
}
