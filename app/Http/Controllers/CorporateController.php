<?php

namespace App\Http\Controllers;

class CorporateController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:corporates.view')->only('index');
        $this->middleware('can-access:corporates.create')->only('create');
        $this->middleware('can-access:corporates.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'corporate-users-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'corporate-users-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'corporate-users-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'corporate-users-show', 'id' => $id]);
    }
}
