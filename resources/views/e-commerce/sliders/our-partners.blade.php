<section class="pt-3 pt-md-4">

            <!-- Heading-->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
              <div>
                <h2 class="h3 mb-0 pt-3 me-3">Our Partners</h2>
              </div>
            </div>
            <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled pt-2">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
                <!-- partners-->
              @foreach($partners as $partner) 
                <div>
                  <div class="card product-card card-static pb-3">
                  @if($partner->logo)
                    <a class="card-img-top d-block overflow-hidden text-center" href="#">
                      <img class="product-image" src="{{asset($partner->logo->url)}}" alt="{{$partner->name}}" width="280px" height="280px" loading="lazy">
                    </a>
                  @endif
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </section>