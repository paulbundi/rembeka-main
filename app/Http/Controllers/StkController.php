<?php

namespace App\Http\Controllers;

class StkController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:stk-push.view')->only('index');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'stk-index']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'skt-show', 'id' => $id]);
    }
}
