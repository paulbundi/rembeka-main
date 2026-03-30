<?php

namespace App\Http\Controllers;

class AdvertController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:adverts.view')->only('index');
        $this->middleware('can-access:adverts.create')->only('create');
        $this->middleware('can-access:adverts.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'advert-index']);
    }
}
