@if($discounted->count() > 0)
<section class="pt-3 pt-md-4">
    <!-- Heading-->
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4">
      <h2 class="h3 mb-0 pt-3 me-3 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">New Arrivals</h2>
      <div class="pt-3">
        <a class="btn btn-sm hover-pink-text fw-bold text-decoration-none" href="{{ route('search.index') }}" style="color: #c12c5d;">
          View all <i class="ci-arrow-right ms-1"></i>
        </a>
      </div>
    </div>
    <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled pt-2">
      <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
        <!-- Product-->
        @foreach($discounted as $discount) 
          @php
            $product = $discount->product;
            $media = optional(optional(optional($product)->attachments)->first())->media;
          @endphp
          @if($product && $media)
            <div>
              <div class="card product-card card-static pb-3"><span class="badge bg-danger badge-shadow"> {{(int)$discount->discount_amount}} % off</span>
                <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i></button>
              <a class="card-img-top d-block overflow-hidden text-center" href="{{ route('product.show', ['slug' => $product->slug, 'productId' => $product->id ])}}">
                <img class="product-image" src="{{asset($media->url)}}" alt="{{$media->name ?? $product->name}}" loading="lazy">
              </a>
                <div class="card-body py-2"><a class="product-meta d-block fs-xs pb-1" href="#">{{ $product->name }}</a>
                  <h3 class="product-title fs-sm text-truncate">
                    <a href="{{ route('product.show', ['slug' => $product->slug, 'productId' => $product->id ])}}">{{  $product->name }}</a>
                  </h3>
                  <div class="product-price">
                    <div class="product-price">
                      Ksh <span class="text-danger fw-bold"> {{ number_format($discount->payable) }}</span>
                      <del class="fs-sm text-muted">{{ $product->final_price }}</del>
                    </div>
                  </div>
                </div>
                <div class="product-floating-btn">
                  <a href="{{ route('product.show', ['slug' => $product->slug, 'productId' => $product->id])}}" class="btn btn-primary btn-shadow btn-sm" type="button">+<i class="ci-cart fs-base ms-1"></i></a>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </section>
  @endif
