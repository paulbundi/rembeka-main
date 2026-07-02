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

            <!-- Paystack Payment (Default) -->
            <div class="accordion-item">
              <h3 class="accordion-header">
                <a class="accordion-button text-primary" href="#paystack" data-bs-toggle="collapse">
                  <i class="ci-card fs-lg me-2 align-middle text-success"></i>Pay with Paystack (Cards & Mobile Money)</a>
              </h3>
              <div class="accordion-collapse collapse show" id="paystack" data-bs-parent="#payment-method">
                <div class="accordion-body">
                  <div class="text-center p-3">
                    <i class="ci-credit-card fs-lg me-2 align-middle text-success"></i>
                    <p class="small text-muted mt-2">Secure online payment via cards, mobile money and more</p>
                  </div>

                  @if(isset($response['type']) && $response['type'] == 'error')
                    <b class="text-danger text-center">{{$response['notice'] ?? $response['message'] ?? ''}}</b>
                  @endif

                  <form method="POST" action="{{ route('paystack.initialize') }}" class="credit-card-form row"
                    id="paystack-form">
                    @csrf
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="mb-3 w-100">
                          <label class="form-label" for="paystack-email">Email Address</label>
                          <input class="form-control" name="email" value="{{auth()->user()->email ?? old('email')}}"
                            type="email" id="paystack-email" required>
                          @error('email')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-success d-block w-100 mt-1" type="submit" id="paystack-btn">
                          <span class="fw-bolder">Pay Ksh {{ number_format((float) Cart::total(), 2) }}</span>
                        </button>
                      </div>
                    </div>
                  </form>

                  <div class="alert alert-info mt-3" role="alert">
                    <h5 class="alert-heading">Paystack Payment</h5>
                    <p class="mb-2">
                      Pay securely using your credit/debit card, M-Pesa, or other mobile money options.
                      Your payment is processed instantly and securely.
                    </p>
                    <hr>
                    <p class="mb-0 small text-muted">
                      Click the "Pay" button to be redirected to Paystack's secure payment page.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h3 class="accordion-header">
                <a class="accordion-button text-primary" href="#mpesa" data-bs-toggle="collapse">
                  <i class="ci-card fs-lg me-2 align-middle text-success"></i>Pay with Mpesa.</a>
              </h3>
              <div class="accordion-collapse collapse show" id="mpesa" data-bs-parent="#payment-method">
                <div class="accordion-body">
                  <div class="text-center p-3">
                    <img src="{{ asset('mpesa.png') }}" alt="M-Pesa" height="60">
                  </div>

                  {{--
                  |--------------------------------------------------------------------------
                  | MANUAL PAYMENT FLOW
                  |--------------------------------------------------------------------------
                  | Switched from STK Push to manual C2B payments to phone number 0708887933.
                  | Customers send money via M-Pesa manually and submit transaction details.
                  | Old STK Push logic is preserved below as comments for reference/rollback.
                  |--------------------------------------------------------------------------
                  --}}
                  <!-- @if(isset($response['type']) && $response['type'] == 'success')
                                  <img src="https://www.tiaro.net/site/assets/files/11317/mpesa.png" alt="M-Pesa Payment" height="60">
                                  <p class="small text-muted mt-2">Pay with M-Pesa</p>
                                  <div class="col-12 d-flex flex-column justify-content-center">
                                    <h4>Payment Request Made successfully.</h4>
                                    <p>Check your phone and enter your mpesa pin to complete the transaction.</p>
                                    <a class="btn btn-sm btn-primary" href="{{ route('validate.stk') }}">Kindly click here to validate
                                      payment</a>
                                  </div>
                                @else
                                  <form method="POST" action="{{ route('complete.order') }}" class="credit-card-form row">
                                    @csrf
                                    <div class="row">
                                      <div class="col-sm-6">
                                        @if(isset($response['type']) && $response['type'] == 'error')
                                          <b class="text-danger text-center">{{$response['notice'] ?? $response['message'] ?? ''}}</b>
                                        @endif
                                        <div class="mb-3 w-100">
                                          <label class="form-label" for="checkout-fn">Phone number to pay with</label>
                                          <input class="form-control" name="phone" value="{{auth()->user()->phone}}" type="tel"
                                            id="checkout-fn" required>
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
                                @endif -->
                  {{-- /MANUAL PAYMENT FLOW: Old STK Push logic --}}

                  {{--
                  Switched from STK Push to manual C2B payments to phone number 0708887933.
                  Removed old STK Push UI. Old code preserved in git history.
                  --}}
                  @if(isset($response['type']) && $response['type'] == 'success')
                    <img src="https://www.tiaro.net/site/assets/files/11317/mpesa.png" alt="M-Pesa Payment" height="60">
                    <p class="small text-muted mt-2">Pay with M-Pesa</p>
                    <div class="col-12 d-flex flex-column justify-content-center">
                      <h4>Payment Request Made successfully.</h4>
                      <p>Please send <strong>Ksh
                          {{ isset($response['order']) && $response['order'] ? number_format($response['order']->balance, 2) : number_format((float) Cart::total(), 2) }}</strong>
                        to <strong>0708887933</strong> via M-Pesa and submit the Transaction ID below.</p>
                    </div>
                  @endif

                  <div class="alert alert-info mt-3" role="alert">
                    <h5 class="alert-heading">Pay manually via M-Pesa</h5>
                    <p class="mb-2">
                      Send <strong>Ksh
                        {{ isset($response['order']) && $response['order'] ? number_format($response['order']->balance, 2) : number_format((float) Cart::total(), 2) }}</strong>
                      to phone number <strong>0708887933</strong> using M-Pesa.
                    </p>
                    <hr>
                    <p class="mb-2 small text-muted">
                      After sending money, enter your M-Pesa transaction details below.
                    </p>
                  </div>

                  <form method="POST" action="{{ route('manual.payment.submit') }}" class="credit-card-form row">
                    @csrf
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="mb-3 w-100">
                          <label class="form-label" for="manual-mpesa-code">M-Pesa Transaction ID / Code</label>
                          <input class="form-control" name="mpesa_transaction_id" type="text" id="manual-mpesa-code"
                            placeholder="e.g. SGH123456" required>
                          @error('mpesa_transaction_id')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="mb-3 w-100">
                          <label class="form-label" for="manual-phone">Phone Number Used</label>
                          <input class="form-control" name="phone" value="{{ auth()->user()->phone ?? old('phone') }}"
                            type="tel" id="manual-phone" required>
                          @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="mb-3 w-100">
                          <label class="form-label" for="manual-amount">Amount Sent (Ksh)</label>
                          <input class="form-control" name="amount" type="number" step="0.01" min="1" id="manual-amount"
                            value="{{ isset($response['order']) && $response['order'] ? number_format($response['order']->balance, 2) : number_format((float) Cart::total(), 2) }}"
                            required>
                          @error('amount')
                            <small class="text-danger">{{ $message }}</small>
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

                  {{--
                  |--------------------------------------------------------------------------
                  | MANUAL PAYMENT INSTRUCTIONS
                  |--------------------------------------------------------------------------
                  | Send payment via M-Pesa to the dedicated phone number and submit the
                  | transaction details below so we can verify and confirm your order.
                  |--------------------------------------------------------------------------
                  --}}
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h3 class="accordion-header">
                <a class="accordion-button collapsed" href="#cod" data-bs-toggle="collapse">
                  <i class="ci-card fs-lg me-2 align-middle"></i>Cash on Delivery</a>
              </h3>
              <div class="accordion-collapse collapse" id="cod" data-bs-parent="#payment-method">
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

@push('scripts')
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('paystack-form');
      if (form) {
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          const email = document.getElementById('paystack-email').value;

          fetch('{{ route('paystack.initialize') }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: new URLSearchParams({ email: email })
          })
            .then(response => response.json())
            .then(data => {
              if (data.type === 'success' && data.authorization_url) {
                window.location.href = data.authorization_url;
              } else {
                alert(data.notice || 'Failed to initialize payment');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('An error occurred. Please try again.');
            });
        });
      }
    });
  </script>
@endpush