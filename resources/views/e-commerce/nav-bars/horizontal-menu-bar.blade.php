<div class="horizontal-menu-bar border-top border-bottom border-muted bg-white py-1 d-none d-lg-block">
  <div class="container d-flex justify-content-center">
    <ul class="nav nav-horizontal align-items-center mb-0">
      <li class="nav-item px-3">
        <a class="nav-link fw-bold text-dark text-uppercase position-relative py-2 {{ request()->is('/') ? 'active-home' : '' }}"
          href="{{ url('/') }}" style="font-size: 0.85rem; letter-spacing: 0.5px;">
          Home
        </a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link fw-bold text-dark text-uppercase position-relative py-2" href="{{ route('filter.index') }}"
          style="font-size: 0.85rem; letter-spacing: 0.5px;">
          Brands <span class="badge bg-danger rounded-pill ms-1 align-middle"
            style="font-size: 0.6rem; padding: 2px 5px;">NEW</span>
        </a>
      </li>
      <li class="nav-item px-3 dropdown">
        <a class="nav-link fw-bold text-dark text-uppercase dropdown-toggle py-2" href="#" id="productsDropdown"
          role="button" data-bs-toggle="dropdown" aria-expanded="false"
          style="font-size: 0.85rem; letter-spacing: 0.5px;">
          Products
        </a>
        <ul class="dropdown-menu dropdown-menu-animated mt-2 p-3 border-0 shadow-lg rounded-3"
          aria-labelledby="productsDropdown" style="min-width: 250px; max-height: 420px; overflow-y: auto;">
          @foreach(($menus ?? collect())->where('type', App\Models\Menu::TYPE_PRODUCT) as $pMenu)
          <li class="mb-2">
            @if($pMenu->children && $pMenu->children->count() > 0)
            @php($productsCollapseId = 'productsMenu' . $pMenu->id)
              <button
                class="dropdown-item fw-bold text-dark py-1 px-2 rounded-2 d-flex align-items-center justify-content-between"
                type="button" data-bs-toggle="collapse" data-bs-target="#{{ $productsCollapseId }}" aria-expanded="false"
                aria-controls="{{ $productsCollapseId }}" style="color: #c12c5d !important; background: transparent;">
                <span>{{ $pMenu->name }}</span>
                <span class="ms-2" aria-hidden="true">
                  <i class="ci-chevron-down"></i>
                </span>
              </button>

              <div class="collapse" id="{{ $productsCollapseId }}">
                <ul class="list-unstyled ps-3 mt-1 pb-1 fs-sm">
                  @foreach($pMenu->children as $child)
                    <li>
                      <a class="text-muted d-block py-1 px-2 rounded hover-pink-bg"
                        href="{{ route('browse-by-menu.index', $child->id) }}">{{ $child->name }}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @else
            <a class="dropdown-item fw-bold text-dark py-1 px-2 rounded-2"
              href="{{ route('browse-by-menu.index', $pMenu->id) }}"
              style="color: #c12c5d !important; background: transparent;">
              {{ $pMenu->name }}
            </a>
            @endif
          </li>
          @endforeach
        </ul>
      </li>
      <li class="nav-item px-3 dropdown">
        <a class="nav-link fw-bold text-dark text-uppercase dropdown-toggle py-2" href="#" id="servicesDropdown"
          role="button" data-bs-toggle="dropdown" aria-expanded="false"
          style="font-size: 0.85rem; letter-spacing: 0.5px;">
          Services
        </a>
        <ul class="dropdown-menu dropdown-menu-animated mt-2 p-3 border-0 shadow-lg rounded-3"
          aria-labelledby="servicesDropdown" style="min-width: 250px;">
          @foreach(($menus ?? collect())->where('type', App\Models\Menu::TYPE_SERVICE) as $sMenu)
            <li class="mb-2">
              <a class="dropdown-item fw-bold text-dark py-1 px-2 rounded-2"
                href="{{ route('browse-by-menu.index', $sMenu->id) }}"
                style="color: #c12c5d !important; background: transparent;">
                {{ $sMenu->name }}
              </a>
              @if($sMenu->children && $sMenu->children->count() > 0)
                <ul class="list-unstyled ps-3 mt-1 pb-1 fs-sm">
                  @foreach($sMenu->children as $child)
                    <li><a class="text-muted d-block py-1 px-2 rounded hover-pink-bg"
                        href="{{ route('browse-by-menu.index', $child->id) }}">{{ $child->name }}</a></li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link fw-bold text-dark text-uppercase position-relative py-2" href="#offers"
          style="font-size: 0.85rem; letter-spacing: 0.5px;">
          Offers <span class="badge bg-danger rounded-pill ms-1 align-middle"
            style="font-size: 0.6rem; padding: 2px 5px;">HOT</span>
        </a>
      </li>
    </ul>
  </div>
</div>