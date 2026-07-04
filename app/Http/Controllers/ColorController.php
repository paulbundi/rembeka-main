<?php

namespace App\Http\Controllers;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:products.view')->only('index');
        $this->middleware('can-access:products.create')->only('create');
        $this->middleware('can-access:products.update')->only('edit');
    }

    public function index()
    {
        return view('dashboard.page', ['page' => 'color-index']);
    }

    public function create()
    {
        return view('dashboard.page', ['page' => 'color-create']);
    }

    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'color-create', 'id' => $id]);
    }

    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'color-create', 'id' => $id]);
    }
}