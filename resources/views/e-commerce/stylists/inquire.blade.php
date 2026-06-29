@extends('layouts.e-commerce')
@section('content')
@php
  $menus = $menus ?? collect();
@endphp
<main class="profile-padding">
    <section>
      <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4">
          <h2 class="h3 mb-0 pt-3 me-3 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">Adorn Picks
          </h2>
        </div>

        <div class="tns-carousel tns-controls-static tns-controls-outside tns-dots-enabled pt-2">
          <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "gutter": 16, "controls": true, "autoHeight": true, "responsive": {"0":{"items":1}, "480":{"items":2}, "720":{"items":3}, "991":{"items":2}, "1140":{"items":3}, "1300":{"items":4}, "1500":{"items":5}}}'>

            @foreach($adornProducts ?? [] as $pricing)
              @php
                $product = optional($pricing)->product;
                $media = null;
                if ($product) {
                    $firstAttachment = optional($product->attachments)->first();
                    $media = optional($firstAttachment)->media;
                }
              @endphp

              @if($product && $media)
                <div class="card product-card card-static pb-3">
                  <a class="card-img-top d-block overflow-hidden text-center"
                     href="{{ route('product.show', ['slug' => $product->slug, 'productId' => $product->id]) }}">
                    <img class="product-image" src="{{ asset($media->url) }}" alt="{{ $media->name ?? $product->name }}" />
                  </a>

                  <div class="card-body py-2">
                    @if($product->category)
                      <a class="product-meta d-block fs-xs pb-1" href="#">{{ $product->category->name }}</a>
                    @endif

                    <h3 class="product-title fs-sm text-truncate">
                      <a href="{{ route('product.show', ['slug' => $product->slug, 'productId' => $product->id]) }}">
                        {{ $product->name }}
                      </a>
                    </h3>

                    <div class="product-price">
                      <span class="text-accent">Ksh {{ $product->final_price }}</span>
                    </div>
                  </div>

                  <div class="product-floating-btn">
                    <a href="{{ route('product.show', ['slug' => $product->slug, 'productId' => $product->id]) }}"
                       class="btn btn-primary btn-shadow btn-sm" type="button">
                      +<i class="ci-cart fs-base ms-1"></i>
                    </a>
                  </div>
                </div>
              @endif
            @endforeach

          </div>
        </div>
      </div>

      <div class="container py-5">
        <div class="d-flex justify-content-center border-bottom pb-2 mb-4">
          <h2 class="h3 mb-0 pt-3 text-uppercase fw-bold text-center" style="color: #1e293b; letter-spacing: 0.5px;">Our Partners</h2>
        </div>
        <div class="row g-4 justify-content-center">
          <div class="col-6 col-md-5 col-lg-4">
            <a href="https://www.hevafund.com/" target="_blank" rel="noopener" class="text-decoration-none">
              <div class="card border-0 bg-white shadow-sm h-100 hover-lift">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                  <img src="https://rembekaonline.com/storage/media/FR3I7jDVhWxPLgA4WMPGnuD4GpMOIBV6KI6YCwwN.png" alt="Heva Fund" class="img-fluid partner-card-img" style="max-height: 120px; object-fit: contain; transition: transform 0.3s ease;">
                  <p class="fw-bold text-dark mt-3 mb-0 text-center">Heva Fund</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-6 col-md-5 col-lg-4">
            <a href="https://www.afrinext.net/" target="_blank" rel="noopener" class="text-decoration-none">
              <div class="card border-0 bg-white shadow-sm h-100 hover-lift">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                  <img src="https://rembekaonline.com/storage/media/b2n8yP8efXFNwUwQKuOUw84oPL3hxqnBpZ1RpypU.jpg" alt="AfriNext" class="img-fluid partner-card-img" style="max-height: 120px; object-fit: contain; transition: transform 0.3s ease;">
                  <p class="fw-bold text-dark mt-3 mb-0 text-center">AfriNext</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>

    @include('layouts.e-commerce-footer')
    </section>
</main>

@endsection
