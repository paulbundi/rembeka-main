@extends('layouts.e-commerce')
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
                  <a class="accordion-button text-primary" href="#mpesa" data-bs-toggle="collapse">
                    <i class="ci-card fs-lg me-2 align-middle text-success"></i>Pay with Mpesa.</a>
                </h3>
                <div class="accordion-collapse collapse show" id="mpesa" data-bs-parent="#payment-method">
                  <div class="accordion-body">
                    <div class="credit-card-wrapper"></div>
                    @if(isset($response['type']) && $response['type'] == 'success')
                      
                      <div class="col-12 d-flex flex-column justify-content-center">
                        <h4>Payment Request Made successfully.</h4>
                        <p>Check your phone and enter your mpesa pin to complete the transaction.</p>
                        <a class="btn btn-sm btn-primary" href="{{ route('validate.stk') }}">Kindly click here to validate payment</a>
                      </div>
                    @else

                      <form method="POST" action="{{ route('complete.order') }}" class="credit-card-form row">
                        @csrf
                            <div class="row">
                              <div class="col-sm-6">
                                @if(isset($response['type']) && $response['type'] == 'error')
                                  <b class="text-danger text-center">{{$response['message'] }}</b>
                                @endif
                                  <div class="mb-3 w-100">
                                  <label class="form-label" for="checkout-fn">Phone number to pay with</label>
                                  <input class="form-control" name="phone"  value="{{auth()->user()->phone}}"  type="tel" id="checkout-fn" required>
                                  @error('phone')
                                  <small class="text-danger">{{ $message  }}</small>
                                  @enderror
                                </div>
                              </div>
                        
                            <div class="col-sm-6">
                              <label>&nbsp;</label>
                              <button class="btn btn-primary d-block w-100 mt-1" type="submit">
                                <span class="fw-bolder">Make Payment</span>
                              </button>
                            </div>
                          </div>
                      </form>
                    @endif
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h3 class="accordion-header">
                    <a class="accordion-button text-primary" href="#card" data-bs-toggle="collapse">
                    <i class="ci-card fs-lg me-2  align-middle"></i>Pay on delivery</a></h3>
                  <div class="accordion-collapse collapse show" id="card" data-bs-parent="#payment-method">
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

                
              <!-- Payment with card -->
              <!-- <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button" href="#card" data-bs-toggle="collapse"><i class="ci-card fs-lg me-2 mt-n1 align-middle"></i>Pay with Credit Card</a></h3>
                <div class="accordion-collapse collapse show" id="card" data-bs-parent="#payment-method">
                  <div class="accordion-body">
                    <p class="fs-sm">We accept following credit cards:&nbsp;&nbsp;<img class="d-inline-block align-middle" src="img/cards.png" width="187" alt="Cerdit Cards"></p>
                    <div class="credit-card-wrapper"></div>
                    <form class="credit-card-form row">
                      <div class="mb-3 col-sm-6">
                        <input class="form-control" type="text" name="number" placeholder="Card Number" required>
                      </div>
                      <div class="mb-3 col-sm-6">
                        <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                      </div>
                      <div class="mb-3 col-sm-3">
                        <input class="form-control" type="text" name="expiry" placeholder="MM/YY" required>
                      </div>
                      <div class="mb-3 col-sm-3">
                        <input class="form-control" type="text" name="cvc" placeholder="CVC" required>
                      </div>
                      <div class="col-sm-6">
                        <button class="btn btn-outline-primary d-block w-100 mt-0" type="submit">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div> -->

              <!-- Paypal here -->
              <!-- <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button collapsed" href="#paypal" data-bs-toggle="collapse"><i class="ci-paypal me-2 align-middle"></i>Pay with PayPal</a></h3>
                <div class="accordion-collapse collapse" id="paypal" data-bs-parent="#payment-method">
                  <div class="accordion-body fs-sm">
                    <p><span class='fw-medium'>PayPal</span> - the safer, easier way to pay</p>
                    <form class="row needs-validation" method="post" novalidate>
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <input class="form-control" type="email" placeholder="E-mail" required>
                          <div class="invalid-feedback">Please enter valid email address</div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <input class="form-control" type="password" placeholder="Password" required>
                          <div class="invalid-feedback">Please enter your password</div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center"><a class="nav-link-style" href="#">Forgot password?</a>
                          <button class="btn btn-primary" type="submit">Log In</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div> -->

              <!-- redemable coupons/point -->
              <!-- <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button collapsed" href="#points" data-bs-toggle="collapse"><i class="ci-gift me-2"></i>Redeem Reward Points</a></h3>
                <div class="accordion-collapse collapse" id="points" data-bs-parent="#payment-method">
                  <div class="accordion-body">
                    <p>You currently have<span class="fw-medium">&nbsp;384</span>&nbsp;Reward Points to spend.</p>
                    <div class="form-check d-block">
                      <input class="form-check-input" type="checkbox" id="use_points">
                      <label class="form-check-label" for="use_points">Use my Reward Points to pay for this order.</label>
                    </div>
                  </div>
                </div>
              </div> -->

            </div>
            <!-- Navigation (desktop)-->
    
          </section>
          <!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
          @if(isset($response['type']) && $response['order'])

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
              <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="checkout-shipping.html"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Shipping</span><span class="d-inline d-sm-none">Back</span></a></div>
              <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{route('checkout.cart')}}"><span class="d-none d-sm-inline">Review your order</span><span class="d-inline d-sm-none">Review order</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>
          </div>
        </div>
      </div>
</main>
@endsection