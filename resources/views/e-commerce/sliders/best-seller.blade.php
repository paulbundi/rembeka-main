<section class="pt-5 pb-4">
            <!-- Heading-->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4">
              <h2 class="h3 mb-0 pt-3 me-3">Bestsellers</h2>
              <div class="pt-3"><a class="btn btn-outline-accent btn-sm" href="{{ route('search.index') }}">More products<i class="ci-arrow-right ms-1 me-n1"></i></a></div>
            </div>
            <div class="tns-carousel tns-controls-static tns-controls-outside tns-dots-enabled pt-2">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
                <!-- Product-->
                @foreach($bestSellers as $bestseller)
                  @if($bestseller->product->attachments && $bestseller->product->attachments->count() > 0)
                  <div class="card product-card card-static pb-3">
                    <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i></button>
                    <a class="card-img-top d-block overflow-hidden text-center" href="{{ route('product.show', ['slug' => $bestseller->product->slug, 'productId' => $bestseller->product->id ])}}">
                      <img class="product-image" src="{{asset($bestseller->product->attachments->first()->media->url)}}" alt="Product">
                    </a>
                    <div class="card-body py-2">
                      @if($bestseller->product->category)
                        <a class="product-meta d-block fs-xs pb-1" href="#">{{ $bestseller->product->category->name }}</a>
                      @endif
                      <h3 class="product-title fs-sm text-truncate"><a href="{{route('product.show',  ['slug' => $bestseller->product->slug, 'productId' => $bestseller->product->id ])}}">{{$bestseller->product->name }}</a></h3>
                      <div class="product-price"><span class="text-accent"> Ksh {{$bestseller->product->final_price}} </div>
                    </div>
                    <div class="product-floating-btn">
                      <a href="{{ route('product.show', ['slug' => $bestseller->product->slug, 'productId' => $bestseller->product->id ])}}" class="btn btn-primary btn-shadow btn-sm" type="button">+<i class="ci-cart fs-base ms-1"></i></a>
                    </div>
                  </div>
                  @endif
                @endforeach
              </div>
            </div>
          </section>