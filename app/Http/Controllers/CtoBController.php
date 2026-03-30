<?php

namespace App\Http\Controllers;

class CtoBController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:transactions.mpesa-deposit')->only('index');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'ctob-index']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'ctob-show', 'id' => $id]);
    }
}
