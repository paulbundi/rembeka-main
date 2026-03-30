<?php

namespace App\Http\Controllers;

class TransportRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:transport-requests.view')->only('index');
        $this->middleware('can-access:transport-requests.create')->only('create');
        $this->middleware('can-access:transport-requests.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'transport-request-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'transport-request-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'transport-request-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'transport-request-show', 'id' => $id]);
    }
}
