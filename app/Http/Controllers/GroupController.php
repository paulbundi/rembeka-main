<?php

namespace App\Http\Controllers;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:groups.view')->only('index');
        $this->middleware('can-access:groups.create')->only('create');
        $this->middleware('can-access:groups.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'groups-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'groups-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'groups-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'groups-show', 'id' => $id]);
    }
}
