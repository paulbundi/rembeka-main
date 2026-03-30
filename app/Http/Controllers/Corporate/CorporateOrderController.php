<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;

class CorporateOrderController extends Controller
{
    /**
     * corporate order index
     *
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'corporate-orders-index']);
    }

    /**
     * corporate order show
     *
     * @return void
     */
    public function show(int $order)
    {
        return view('dashboard.page', [
            'page' => 'corporate-orders-show',
            'id' => $order
        ]);
    }
}
