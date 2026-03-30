@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8 card">
            <!-- Orders list-->
            @if($orders->count() == 0)
              <div class="mt-3">
                <div class="alert alert-info text-center">
                  <h4>Your currenly have no orders placed.</h4>
                  <a href="/" class="btn btn-primary mt-2"> Browse Our Catalogue</a>
                </div>
              </div>
            @else
              <div class="card-body table-responsive fs-md mb-4">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th>Order #</th>
                      <th>Date Purchased</th>
                      <th>Amount</th>
                      <th>Paid</th>
                      <th>Balance</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $order)
                    <tr>
                      <td class="py-3">
                        <a class="nav-link-style fw-medium fs-sm" href="{{ route('orders.show', $order->id) }}">{{ $order->order_no}}</a></td>
                      <td class="py-3">{{ date_format($order->created_at, 'd-M-Y: H:i:s') }}</td>
                      <td class="py-3">{{ $order->amount }}</td>
                      <td class="py-3">{{ $order->paid }}</td>
                      <td class="py-3">{{ $order->balance }}</td>
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
                      <td class="py-3">
                        <a href="{{ route('orders.show', $order->id) }}" class="badge bg-success">view</a>
                        @if($order->balance > 0)
                        <a href="#" class="badge bg-primary">Make payment</a>

                        @endif
                      </td>
                    </tr>
                    @endforeach

        
                  </tbody>
                </table>
              </div>
            @endif
            <!-- Pagination-->
            {{ $orders->links()}}

          </section>

        </div>
    </div>
</main>
@endsection