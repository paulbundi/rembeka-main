<?php

namespace App\Http\Controllers;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:partners.view')->only('index');
        $this->middleware('can-access:partners.create')->only('create');
        $this->middleware('can-access:partners.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'partners-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'partners-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'partners-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'partners-show', 'id' => $id]);
    }
}
