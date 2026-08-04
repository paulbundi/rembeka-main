@extends('layouts.e-commerce')
@php
  use App\Facades\Cart;
@endphp
@section('content')
  <main class="page-wrapper">
    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
              <li class="breadcrumb-item"><a class="text-nowrap" href="index.html"><i class="ci-home"></i>Home</a></li>
              <li class="breadcrumb-item text-nowrap"><a href="shop-grid-ls.html">Shop</a>
              </li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">Checkout</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
          <h1 class="h3 text-light mb-0">Checkout</h1>
        </div>
      </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
      <div class="row">
        <section class="col-lg-8">
          <!-- Steps-->
          @include('e-commerce.checkouts.partials.checkout-steps')

          <!-- Payment methods accordion-->
          <h2 class="h6 pb-3 mb-2">Choose payment method</h2>
          <div class="accordion mb-2" id="payment-method">

            <div class="accordion-item">
              <h3 class="accordion-header">
                <a class="accordion-button collapsed" href="#cod" data-bs-toggle="collapse">
                  <img src="{{ asset('img/cash_on_delivery.png') }}" alt="Cash on Delivery" height="24" class="me-2">Cash on Delivery</a>
              </h3>
              <div class="accordion-collapse collapse show" id="cod" data-bs-parent="#payment-method">
                <div class="accordion-body">
                  <div class="credit-card-wrapper"></div>
                  <form class="credit-card-form row" action="{{ route('pay-on.delivery')}}" method="post">
                    <div class="w-100 text-center">
                      @csrf
                      <p class="bold">Proceed with checkout and make payment on delivery.</p>
                      <button class="btn btn-dark d-block w-100 mt-0" type="submit">Proceed </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
          <!-- Navigation (desktop)-->

        </section>
        <!-- Sidebar-->
        <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
          @if(isset($response['type']) && isset($response['order']) && $response['order'])

            @include('e-commerce.orders.payment-order-summary')

          @else
            <order-summary-details />
          @endif
        </aside>
      </div>
      <!-- Navigation (mobile)-->
      <div class="row d-lg-none">
        <div class="col-lg-8">
          <div class="d-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="checkout-shipping.html"><i
                  class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Shipping</span><span
                  class="d-inline d-sm-none">Back</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{route('checkout.cart')}}"><span
                  class="d-none d-sm-inline">Review your order</span><span class="d-inline d-sm-none">Review
                  order</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

<script>
  window.checkout = {
    deliveryFee: {{ session('delivery_fee', 0) }},
    deliveryMethod: '{{ session('delivery_method', 'PICKUP') }}',
  };
</script>