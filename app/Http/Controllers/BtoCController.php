<?php

namespace App\Http\Controllers;

class BtoCController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:transactions.mpesa-withdraw')->only('index');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'btoc-index']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'btoc-show', 'id' => $id]);
    }
}
