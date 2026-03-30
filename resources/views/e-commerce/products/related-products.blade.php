<section class="pb-5 mb-2 mb-xl-4">
            <h2 class="h3 pb-2 mb-grid-gutter text-center">You may also like</h2>
            <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
                <!-- Product-->

                @foreach($relatedProducts as $related)

                @if($related->type == App\Models\Product::TYPE_PRODUCT)
                  @foreach($related->supplierPrice as $pricing)
                    <div>
                      <div class="card product-card card-static pb-3">
                        @if($pricing->discount)
                          <span class="badge bg-danger badge-shadow"> {{ (int) $pricing->discount->discount_amount }}% off</span>
                        @endif
                       
                        <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i></button>
                        <a class="card-img-top d-block overflow-hidden" href="{{route('product.show', ['slug' => $related->slug, 'productId' => $related->id ])}}"  style="max-height:250px;">
                          @if($related->attachments->count() && $related->attachments->first()->media->url)
                            <img src="{{ asset($related->attachments()->first()->media->url)}}" alt="Product">
                          @else
                            <img src="{{ asset('img/default.png')}}" alt="Product">
                          @endif
                        </a>
                        <div class="card-body py-2">
                            <h3 class="product-title fs-sm"><a href="{{route('product.show', ['slug' => $related->slug, 'productId' => $related->id ])}}">{{$related->name}}</a></h3>
                            <div class="product-price">
                            @if($pricing->discount)
                              <span class="text-danger fw-bold">Ksh {{ number_format($pricing->discount->payable) }}</span>
                              <del class="fs-sm text-muted">{{ number_format($pricing->discount->product_price) }}</del>
                            @else
                              <span class="text-danger fw-bold">Ksh {{ number_format($pricing->amount) }}</span>
                            @endif
                          </div>
                        </div>
                        <div class="product-floating-btn">
                          <a href="{{route('product.show', ['slug' => $related->slug, 'productId' => $related->id ])}}" class="btn btn-primary btn-shadow btn-sm" type="button">+<i class="ci-cart fs-base ms-1"></i></a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                <div>
                  <div class="card product-card card-static pb-3">
                    @if($related->discount)
                      <span class="badge bg-danger badge-shadow"> {{ (int) $related->discount->discount_amount }}% off</span>
                    @endif
                    <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i></button>
                    <a class="card-img-top d-block overflow-hidden" href="{{route('product.show', ['slug' => $related->slug, 'productId' => $related->id ])}}">
                      @if($related->attachments->count() && $related->attachments->first()->media->url)
                        <img src="{{ asset($related->attachments()->first()->media->url)}}" alt=">{{$related->name}}" width="280px" height="280px" loading="lazy">
                      @else
                        <img src="{{ asset('img/default.png')}}" alt=">{{$related->name}}" width="280px" height="280px" loading="lazy">
                      @endif
                    </a>
                    <div class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="{{route('product.show', ['slug' => $related->slug, 'productId' => $related->id ])}}">{{$related->name}}</a></h3>
                        <div class="product-price">
                        @if($related->discount)
                          <span class="text-danger fw-bold">Ksh {{ number_format($related->discount->payable) }}</span>
                          <del class="fs-sm text-muted">{{ number_format($related->discount->product_price) }}</del>
                        @else
                          <span class="text-danger fw-bold">Ksh {{ number_format($related->final_price) }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="product-floating-btn">
                      <a href="{{route('product.show', ['slug' => $related->slug, 'productId' => $related->id ])}}" class="btn btn-primary btn-shadow btn-sm" type="button">+<i class="ci-cart fs-base ms-1"></i></a>
                    </div>
                  </div>
                </div>
                @endif
                
                @endforeach
              </div>
            </div>
          </section>