<?php

namespace App\Http\Controllers;

use App\Models\Order;
use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:orders.view')->only('index');
        $this->middleware('can-access:orders.create')->only('create');
        $this->middleware('can-access:orders.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'orders-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'orders-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'orders-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'orders-show', 'id' => $id]);
    }

    /**
     * Load invoice
     *
     * @param int $id
     *
     * @return void
     */
    public function generateInvoice(int $id)
    {
        $order = Order::findOrFail($id);

        $pdf = PDF::loadView('mail.pdf.order-payment', [
                'order' => $order,
            ]);

        return $pdf->download('invoice.pdf');
    }

    /**
     * Corporate Orders.
     *
     * @return void
     */
    public function createCorporateOrders()
    {
        return view('dashboard.page', ['page' => 'corporate-orders-create']);
    }
}
