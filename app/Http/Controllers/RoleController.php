<?php

namespace App\Http\Controllers;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:roles.view')->only('index');
        $this->middleware('can-access:roles.create')->only('create');
        $this->middleware('can-access:roles.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'role-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'role-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'role-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'role-show', 'id' => $id]);
    }
}
