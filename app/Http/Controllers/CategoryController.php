<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:categories.view')->only('index');
        $this->middleware('can-access:categories.create')->only('create');
        $this->middleware('can-access:categories.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'categories-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'categories-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'categories-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'categories-show', 'id' => $id]);
    }
}
