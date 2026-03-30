<?php

namespace App\Http\Controllers;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:channels.view')->only('index');
        $this->middleware('can-access:channels.create')->only('create');
        $this->middleware('can-access:channels.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'channels-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'channels-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'channels-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'channels-show', 'id' => $id]);
    }
}
