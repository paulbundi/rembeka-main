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
            <!-- Autor info-->
            @if(auth()->check())
            <div class="d-sm-flex justify-content-between align-items-center bg-secondary p-4 rounded-3 mb-grid-gutter">
              <div class="d-flex align-items-center">
                <div class="position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;">
                  <user-icon :user="{{auth()->user()}}" size="avatar-lg"/>    
                </div>
                <div class="ps-3">
                  <h3 class="fs-lg mb-0 fw-bold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h3><span class="text-accent fs-sm">{{ auth()->user()->email}}</span>
                </div>
              </div>
              <a class="btn btn-light btn-sm btn-shadow mt-3 mt-sm-0" href="{{ route('profile.index') }}"><i class="ci-edit me-2"></i>Edit profile</a>
            </div>

            <!-- address location-->
           
            <form method="POST" action="{{ route('payment.mode') }}">
              @csrf
              @if($addresses->count() > 0)
              <label class="fw-bold">Choose Location</label>
                <div class="row">
                  @foreach($addresses as $address)
                    <div class="col-12 col-sm-5 mb-1">
                      <div class="card card-body h-100 d-flex flex-row address-check">
                        <input type="radio" name="address_id" value="{{$address->id}}" class="me-2 mt-1">
                        <div class="d-flex flex-column">
                          <b class="card-title">{{ $address->name }}
                            <a href="{{ route('addresses.edit', $address->id) }}" class="card-link">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                          </b>
                          <small class="card-subtitle mb-2 text-muted">{{ $address->name }}</small>
                          <p class="card-text">
                            @if($address->floor)
                            <small>Floor:</small> {{ $address->floor }} 
                            @endif
                            @if($address->room)
                            <small>Room No:</small> {{ $address->room }}
                            @endif
                          </p>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
                @endif
              @include('e-commerce.checkouts.partials.addresslocation')
            <!-- Navigation (mobile)-->
            <div class="row ">
              <div class="col-lg-12">
                <div class="d-flex  pt-4 mt-3">
                  <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('checkout.cart') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Cart</span><span class="d-inline d-sm-none">Back</span></a></div>
                    <div class="w-100 ps-2"><button type="submit" class="btn btn-primary d-block w-100"><span class="d-none d-sm-inline">Proceed to checkout</span><span class="d-inline d-sm-none">Next/Checkout</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></div>
                </div>
              </div>
            </div>
          </form>

            @else
            <!-- Shipping address-->
            <form method="POST" action="{{ route('checkout.store')}}">
              @csrf
              <div class="d-flex flex-row justify-content-around">
                <b class="h4 pt-1 pb-3 mb-3">
                  Create Account 
                </b>
                <span class="pt-1 pb-3 mb-3">
                  or
                </span>
                <div class="w-50 ps-2"><a class="btn bg-dark d-block text-white w-100" href="{{ route('login') }}"><b class="d-none d-sm-inline text-white">Proceed to Login</b><b class="d-inline d-sm-none"> Log In</b></a></div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                    <label class="form-label" for="checkout-fn">First Name</label>
                      <input class="form-control" name="first_name" type="text" id="checkout-fn" required>
                      @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label" for="checkout-ln">Last Name</label>
                      <input class="form-control" name="last_name" type="text" id="checkout-ln" required>
                      @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label" for="checkout-email">E-mail Address</label>
                      <input class="form-control" name="email" type="email" id="checkout-email" required>
                      @error('email')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label" for="checkout-phone">Phone Number</label>
                      <input class="form-control" name="phone"  type="tel" id="checkout-phone" required>
                      @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label" for="checkout-password">Password</label>
                      <input class="form-control" name="password" type="password" id="checkout-password" required>
                      @error('password')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label" for="checkout-confirm-password">Confrm password</label>
                      <input class="form-control" type="password" name="password_confirmation" id="checkout-confirm-password" required>
                      @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                </div>
              </div>
              @include('e-commerce.checkouts.partials.addresslocation')

            <!-- Navigation (desktop)-->
            <div class="d-none d-lg-flex pt-4 mt-3">
              <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="shop-cart.html"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Cart</span><span class="d-inline d-sm-none">Back</span></a></div>
              <div class="w-50 ps-2">
                <button class="btn btn-primary d-block w-100" type="submit">
                  <span class="d-none d-sm-inline">Proceed to checkout</span>
                  <span class="d-inline d-sm-none">Next</span>
                  <i class="ci-arrow-right mt-sm-0 ms-1"></i>
                </button>
              </div>
            </div>
            <!-- Navigation (mobile)-->
            <div class="row d-lg-none">
              <div class="col-lg-8">
                <div class="d-flex pt-4 mt-3">
                  <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('checkout.cart') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Cart</span><span class="d-inline d-sm-none">Back</span></a></div>
                  <div class="w-50 ps-2"><button type="submit" class="btn btn-primary d-block w-100"><span class="d-none d-sm-inline">Proceed to checkout</span><span class="d-inline d-sm-none">Next</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></div>
                </div>
              </div>
            </div>
            </form>
            @endif

          </section>
          <!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
            <order-summary-details />
          </aside>
        </div>
      </div>
</main>
@endsection