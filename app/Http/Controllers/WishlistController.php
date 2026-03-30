<?php

namespace App\Http\Controllers;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:wishlist.view')->only('index');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'wishlist-index']);
    }
}
