@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8">
            <!-- Orders list-->
            <div class="card table-responsive fs-md mb-4">
                <div class="card-body">
                    <div class="card-title row ">
                        <div class="col-6">Order Details</div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('generate-order.invoice', $order->id) }}" type="button" class="btn btn-success btn-sm me-2 fw-bold"><i class="bi bi-file-earmark-pdf-fill"></i> Invoice</a>
                            @if($order->balance > 0)
                                <a href="#" type="button" class="btn btn-primary btn-sm fw-bold"><i class="bi bi-cash"></i> Make Payment</a>
                            @endif
                        </div>
                    </div>
                  
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date Purchased</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="py-3">
                            <a class="nav-link-style fw-medium fs-sm" href="{{ route('orders.show', $order->id) }}">{{ $order->order_no}}</a></td>
                            <td class="py-3">{{ date_format($order->created_at, 'd,M-Y')}}</td>
                            <td class="py-3">
                            @if($order->status == \App\Models\Order::STATUS_PENDING_PAYMENT || $order->status == \App\Models\Order::STATUS_PAYMENT_FAILED)
                                <span class="badge bg-info m-0">Pending Payment</span>
                            @elseif($order->status == \App\Models\Order::STATUS_PENDING_SERVICE || $order->status == \App\Models\Order::STATUS_PARTIAL_DELIVERY)
                                <span class="badge bg-dark m-0">In Progress</span>
                            @elseif($order->status == \App\Models\Order::STATUS_CANCELED )
                                <span class="badge bg-danger m-0">Cancelled</span>
                            @else
                                <span class="badge bg-success m-0">Completed</span>
                            @endif
                            </td>
                            <td class="py-3">{{ $order->amount }}</td>
                        </tr>

            
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card table-responsive fs-md mb-4">
                <div class="card-body">
                    <div class="card-title">Order Items</div>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product #</th>
                                <th>Quantity</th>
                                <th>amount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3">{{ $item->product->name}}</td>
                                <td class="py-3">{{ $item->quantity }}</td>
                                <td class="py-3">{{ $item->amount }}</td>
                                <td class="py-3">{{ $item->quantity * $item->amount }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </section>

        </div>
    </div>
</main>
@endsection