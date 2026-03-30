<section class="pt-3 pt-md-4">

            <!-- Heading-->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
              <div>
                <h2 class="h3 mb-0 pt-3 me-3">Meet Our Stylist</h2>

                <div class="pt-3"><a class="btn btn-outline-accent btn-sm" href="{{ route('stylists.inquire') }}">Want to join<i class="ci-arrow-right ms-1 me-n1"></i></a></div>
              </div>

              <div class="pt-3"><a class="btn btn-outline-accent btn-sm" href="{{ route('stylists.index') }}">Browse More<i class="ci-arrow-right ms-1 me-n1"></i></a></div>
            </div>
            <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled pt-2">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
                <!-- Product-->
              @foreach($stylists as $stylist) 
                <div>
                  <div class="card product-card card-static pb-3">
                  @if($stylist->profile && $stylist->profile->attachments->first() && $stylist->profile && $stylist->profile->attachments->first()->media )
                    <a class="card-img-top d-block overflow-hidden text-center" href="{{ route('stylist.show', $stylist->slug) }}">
                      <img class="product-image" src="{{asset($stylist->profile->attachments()->first()->media->url)}}" alt="{{$stylist->profile->attachments()->first()->media->name}}" loading="lazy">
                    </a>
                  @endif
                  <div class="card-body py-2">
                    @if($stylist->short_description)
                      <a class="product-meta d-block fs-sm pb-1 mt-1 text-dark" href="{{ route('stylist.show', $stylist->slug) }}">{!! trans($stylist->short_description,['name' => $stylist->name ]) !!}</a>
                    @else
                      <a class="product-meta d-block fs-xs pb-1" href="{{ route('stylist.show', $stylist->slug) }}">{{ $stylist->name }}</a>
                    @endif
                  </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </section>