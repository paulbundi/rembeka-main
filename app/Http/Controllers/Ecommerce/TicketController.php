<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        return view('e-commerce.account.tickets.index');
    }
}
