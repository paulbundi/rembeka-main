@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8">
            <!-- Wishlist-->

           @foreach($wishlists as $list)
            <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
              <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('product.show', ['slug' => $list->product->slug, 'productId' => $list->product->id ]) }}" style="width: 10rem;">
                @if($list->product->attachments()->first())
                  <img src="{{ asset($list->product->attachments()->first()->media->url)}}" alt="Product" height="100" width="100">
                @else
                  <img src="{{ asset('img/default.png')}}" alt="Product">
                @endif
                </a>
                <div class="pt-2">
                  <h3 class="product-title fs-base mb-2">
                    <!-- TODO point to product_pricing after refactoring the wishishlist design-->
                    <a href="{{ route('product.show', ['slug' => $list->product->slug, 'productId' => $list->product->id ]) }}">
                      {{ $list->product->name }}
                      @if($list->product->discount)
                        <span class="badge bg-danger badge-shadow"> {{(int)$list->product->discount->discount_amount}} % off</span>
                      @endif
                    </a>
                  </h3>
                  <div class="fs-sm"><span class="text-muted me-2">
                    {{$list->product->description}}
                  </div>
                  @if($list->product->type == \App\Models\Product::TYPE_SERVICE)
                      <div class="product-price">
                            <div class="product-price">
                              @if($list->product->discount)
                                Ksh <span class="text-danger fw-bold"> {{ number_format($list->product->discount->payable) }}</span>
                                <del class="fs-sm text-muted">{{ $list->product->final_price }}</del>
                              @else
                                  <div class="fs-lg pt-2 text-danger">Ksh {{ number_format($list->product->final_price) }}</div>
                              @endif
                            </div>
                          </div>
                  @endif
                </div>
              </div>
              <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                <a class="btn btn-outline-danger btn-sm" href="{{ route('wishlist.remove', $list->product->slug)}}"><i class="ci-trash me-2"></i>Remove</a>
              </div>
            </div>
            @endforeach

            @if($wishlists->count() == 0)
            <div class="d-sm-flex justify-content-center mt-lg-4 mb-4 pb-3 pb-sm-2">
              <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                <div class="empty-message d-flex flex-column justify-content-center align-items-center mt-4">
                  <i class="bi bi-binoculars-fill fs-4"></i>
                  <h3 class="my-1">No Items on wishlist. </h3> 
                  <a class="btn btn-primary text-white" href="{{ route('search.index') }}">Browser Items</a>
                </div>
              </div>
            </div>
            @endif
          </section>

        </div>
    </div>
</main>
@endsection