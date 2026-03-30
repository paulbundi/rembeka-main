<?php

namespace App\Http\Controllers;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:customer-review.view')->only('index');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'customer-review-index']);
    }
}
