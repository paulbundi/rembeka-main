@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')
          <section class="col-lg-8">
            <div class="row">
              @foreach($orders as $order)
                <div class="col-12 col-sm-5 mb-1 card" style="min-height: 200px;" >
                  <div class="card-body px-1">
                    <div class="d-flex flex-row justify-content-between">
                      @include('e-commerce.account.service-request.partials.customer-details', ['order' => $order])
                      @include('e-commerce.account.service-request.partials.order-status', ['order' => $order])
                    </div>
                      @include('e-commerce.account.service-request.partials.order-location', ['order' => $order])
                    <p>
                      Notes: {{ $order->notes }}
                    </p>
                    @foreach($order->items as $item)
                      @include('e-commerce.account.service-request.partials.order-item',['item' => $item])
                    @endforeach

                    <div class="d-flex justify-content-between mt-2 w-100" style="margin-bottom:5px;">
                      @include('e-commerce.account.service-request.partials.order-operations')
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            {{ $orders->links()}}
          </section>
          <div class="d-inline-block d-sm-none mb-4">
            <div class="create-space mb-4"></div>
          </div>
        </div>
    </div>
</main>
@endsection