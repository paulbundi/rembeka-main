<!-- Sidebar menu-->
<aside class="offcanvas offcanvas-start border-end zindex-lg-5" id="sideNav" tabindex="-1" aria-labelledby="sideNavLabel"
  style="max-width: 19.875rem; width: 85vw;">
  <div class="offcanvas-header border-bottom py-3 px-3">
    <a href="{{ url('/') }}">
      <img src="{{ asset('img/logo-large.png') }}" height="36" alt="Rembeka">
    </a>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <ul class="nav nav-tabs nav-justified mt-0 mb-0" role="tablist" style="min-height: 3rem;">
    <li class="nav-item"><a class="nav-link fw-medium services-list preference-menu" id="services" href="#services"
        data-bs-toggle="tab" role="tab">Services</a></li>
    <li class="nav-item"><a class="nav-link fw-medium products-list preference-menu" href="#products" id="products"
        data-bs-toggle="tab" role="tab">Products</a></li>
  </ul>
  <div class="offcanvas-body px-0 pt-3 pb-0" data-simplebar>
    <div class="tab-content">
      <!-- services /styles-->
      <div class="sidebar-nav tab-pane services-tab fade" id="categories" role="tabpanel">
        <div class="widget widget-categories widget-services">
          <div class="accordion" id="shop-services">
            <!-- Special offers-->
            <div class="accordion-item border-bottom">
              <h3 class="accordion-header px-grid-gutter">
                <a class="nav-link-style d-block fs-md fw-normal py-2" href="#offers">
                  <span class="d-flex align-items-center">
                    <i class="ci-discount fs-lg text-danger mt-n1 me-2"></i>
                    Special Offers
                  </span>
                </a>
              </h3>
            </div>
            <!-- main menu-->
            @foreach(($menus ?? collect())->where('type', App\Models\Menu::TYPE_SERVICE) as $menu)
            <div class="accordion-item border-bottom">
              <h3 class="accordion-header px-grid-gutter">
                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                  data-bs-target="#menu{{$menu->id}}" aria-expanded="false" aria-controls="bakery">
                  <span class="d-flex align-items-center">
                    <span class="me-2">{!! $menu->icon !!}</span>
                    {{$menu->name}}
                  </span>
                </button>
              </h3>
              <div class="collapse" id="menu{{$menu->id}}" data-bs-parent="#shop-categories">
                <div class="px-grid-gutter pt-1 pb-4">
                  <div class="widget widget-links">
                    <ul class="widget-list">
                      <li class="widget-list-item"><a class="widget-list-link fw-bold"
                          href="{{route('browse-by-menu.index', $menu->id)}}">View all</a></li>
                      @foreach($menu->children as $levelOne)
                      <li class="widget-list-item"><a class="widget-list-link"
                          href="{{route('browse-by-menu.index', $levelOne->id)}}">{{ $levelOne->name }}</a>
                        @foreach($levelOne->children as $levelTwo)
                                      <ul class="widget-list pt-1">
                                        <li class="widget-list-item"><a class="widget-list-link"
                                            href="{{route('browse-by-menu.index', $levelTwo->id)}}">{{ $levelTwo->name }}</a></li>
                                      </ul>
                                      @endForeach
                                    </li>
                                    @endForeach
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
          </div>
        </div>
      </div>

      <!-- Products-->
      <div class="sidebar-nav tab-pane products-tab fade" id="products" role="tabpanel">
        <div class="widget widget-categories">
          <div class="accordion" id="shop-categories">
            <!-- Special offers-->
            <div class="accordion-item border-bottom">
              <h3 class="accordion-header px-grid-gutter">
                <a class="nav-link-style d-block fs-md fw-normal py-2" href="#">
                  <span class="d-flex align-items-center">
                    <i class="ci-discount fs-lg text-danger mt-n1 me-2"></i>
                    Special Offers
                  </span>
                </a>
              </h3>
            </div>
            <!-- main menu-->
            @foreach(($menus ?? collect())->where('type', App\Models\Menu::TYPE_PRODUCT) as $pMenu)
            <div class="accordion-item border-bottom">
              <h3 class="accordion-header px-grid-gutter">
                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                  data-bs-target="#menu{{$pMenu->id}}" aria-expanded="false" aria-controls="bakery">
                  <span class="d-flex align-items-center">
                    <span class="me-2">{!! $pMenu->icon !!}</span>
                    {{$pMenu->name}}
                  </span>
                </button>
              </h3>
              <div class="collapse" id="menu{{$pMenu->id}}" data-bs-parent="#shop-categories">
                <div class="px-grid-gutter pt-1 pb-4">
                  <div class="widget widget-links">
                    <ul class="widget-list">
                      <li class="widget-list-item"><a class="widget-list-link fw-bold"
                          href="{{route('browse-by-menu.index', $pMenu->id)}}">View all</a></li>
                      @foreach($pMenu->children as $levelOne)
                      <li class="widget-list-item"><a class="widget-list-link"
                          href="{{route('browse-by-menu.index', $levelOne->id)}}">{{ $levelOne->name }}</a>
                        @foreach($levelOne->children as $levelTwo)
                                      <ul class="widget-list pt-1">
                                        <li class="widget-list-item"><a class="widget-list-link"
                                            href="{{route('browse-by-menu.index', $levelTwo->id)}}">{{ $levelTwo->name }}</a></li>
                                      </ul>
                                      @endForeach
                                    </li>
                                    @endForeach
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
</aside>
<!-- Page-->