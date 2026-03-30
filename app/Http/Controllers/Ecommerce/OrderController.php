<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use PDF;

class OrderController extends Controller
{
    /**
     * @param int $id
     *
     * @return void
     */
    public function index()
    {
        $orders = Order::mine()->withCount(['items'])->paginate();

        return view('e-commerce.account.orders.index', ['orders' => $orders]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        $order = Order::mine()
            ->with(['items.category', 'items.provider', 'items.product'])
            ->findOrFail($id);

        return view('e-commerce.account.orders.show', ['order' => $order]);
    }

    /**
     * Order Invoice.
     *
     * @param Order $order
     *
     * @return void
     */
    public function generateOrderInvoice(int $orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->findOrFail($orderId);

        $pdf = PDF::loadView('mail.pdf.order-payment', [
                'order' => $order,
            ]);

        return $pdf->download('invoice.pdf');
    }
}
