<?php

namespace App\Http\Controllers;

class UnitMeasureController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:unit-measures.view')->only('index');
        $this->middleware('can-access:unit-measures.create')->only('create');
        $this->middleware('can-access:unit-measures.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'unit-measures-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'unit-measures-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'unit-measures-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'unit-measures-create', 'id' => $id]);
    }
}
