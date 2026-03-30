<?php

namespace App\Http\Controllers;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:email-campaigns.view')->only('index');
        $this->middleware('can-access:email-campaigns.create')->only('create');
        $this->middleware('can-access:email-campaigns.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'email-campaign-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'email-campaign-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'email-campaign-create', 'id' => $id]);
    }
}
