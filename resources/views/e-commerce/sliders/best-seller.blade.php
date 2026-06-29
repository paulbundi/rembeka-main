<section class="pt-4 pb-4">
  <!-- Heading-->
  <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4">
    <h2 class="h3 mb-0 pt-3 me-3 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">Best Sellers
    </h2>
    <div class="pt-3">
      <a class="btn btn-sm hover-pink-text fw-bold text-decoration-none" href="{{ route('search.index') }}"
        style="color: #c12c5d;">
        View all <i class="ci-arrow-right ms-1"></i>
      </a>
    </div>
  </div>

  <div class="tns-carousel tns-controls-static tns-controls-outside tns-dots-enabled pt-2">
    <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "gutter": 16, "controls": true, "autoHeight": true, "responsive": {"0":{"items":1}, "480":{"items":2}, "720":{"items":3}, "991":{"items":2}, "1140":{"items":3}, "1300":{"items":4}, "1500":{"items":5}}}'>

      <!-- Adorn Products only (15% discounted) -->
      @foreach($adornProducts ?? [] as $pricing)
        @php
          $product = optional($pricing)->product;
          $discountPercent = 15;
          $media = null;
          if ($product) {
              $firstAttachment = optional($product->attachments)->first();
              $media = optional($firstAttachment)->media;
          }
        @endphp

        @if($product && $media)
          <div class="card product-card card-static pb-3">
            <span class="badge bg-danger badge-shadow"> {{ $discountPercent }}% off</span>

            <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left"
              title="Add to wishlist"><i class="ci-heart"></i></button>

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
</section>