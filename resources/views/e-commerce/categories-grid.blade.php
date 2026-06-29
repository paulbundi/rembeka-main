@php
  $menus = $menus ?? collect();
  $makeupMenu = $menus->first(fn($m) => stripos($m->name, 'makeup') !== false);
  $haircareMenu = $menus->first(fn($m) => stripos($m->name, 'hair') !== false);
  $nailsMenu = $menus->first(fn($m) => stripos($m->name, 'nail') !== false || stripos($m->name, 'beauty') !== false);
  $equipmentMenu = $menus->first(fn($m) => stripos($m->name, 'equipment') !== false);
  $accessoriesMenu = $menus->first(fn($m) => stripos($m->name, 'accessories') !== false || stripos($m->name, 'acc') !== false);
@endphp

<section class="categories-grid-section mb-4 mb-md-5">
  <div class="row g-3 justify-content-center">
    <!-- Card 1: Adorn -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="{{ route('search.index', ['search' => 'Adorn']) }}" class="category-card text-decoration-none d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift border border-light">
        <div class="category-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 45px; height: 45px;">
          <!-- Leaf Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c12c5d" viewBox="0 0 16 16">
            <path d="M8 0c-.176 0-.35.006-.524.017C5.51 1.94 4 4.793 4 8c0 3.207 1.51 6.06 3.476 7.983.174.011.348.017.524.017 4.418 0 8-3.582 8-8s-3.582-8-8-8zm1.025 8c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3z"/>
            <path d="M2.5 11a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg>
        </div>
        <div class="category-text">
          <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">Adorn</h6>
          <small class="text-muted" style="font-size: 0.7rem;">Top Brand</small>
        </div>
      </a>
    </div>

    <!-- Card 2: Makeup -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="{{ $makeupMenu ? route('browse-by-menu.index', $makeupMenu->id) : route('search.index', ['search' => 'Makeup']) }}" class="category-card text-decoration-none d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift border border-light">
        <div class="category-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 45px; height: 45px;">
          <!-- Lipstick Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c12c5d" viewBox="0 0 16 16">
            <path d="M6 1a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3H6V1zM5 5h6v4H5V5zm1 5h4v5.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V10z"/>
          </svg>
        </div>
        <div class="category-text">
          <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">Makeup</h6>
          <small class="text-pink fw-semibold" style="font-size: 0.7rem; color: #c12c5d;">Shop Now</small>
        </div>
      </a>
    </div>

    <!-- Card 3: Haircare -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="{{ $haircareMenu ? route('browse-by-menu.index', $haircareMenu->id) : route('search.index', ['search' => 'Haircare']) }}" class="category-card text-decoration-none d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift border border-light">
        <div class="category-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 45px; height: 45px;">
          <!-- Hair Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c12c5d" viewBox="0 0 16 16">
            <path d="M12.5 1A2.5 2.5 0 0 0 10 3.5v.793c-.092-.046-.188-.087-.289-.12A5.46 5.46 0 0 0 8 4a5.46 5.46 0 0 0-1.711.273c-.1.033-.197.074-.289.12V3.5A2.5 2.5 0 0 0 3.5 1h-.5a.5.5 0 0 0-.5.5v1.2c0 2.222 1.488 4.108 3.535 4.672C6.012 7.587 6 7.79 6 8a4 4 0 0 0 8 0c0-.21-.012-.413-.035-.628C16.012 6.808 17.5 4.922 17.5 2.7V1.5a.5.5 0 0 0-.5-.5h-.5zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
          </svg>
        </div>
        <div class="category-text">
          <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">Haircare</h6>
          <small class="text-pink fw-semibold" style="font-size: 0.7rem; color: #c12c5d;">Shop Now</small>
        </div>
      </a>
    </div>

    <!-- Card 4: Nails & Beauty -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="{{ $nailsMenu ? route('browse-by-menu.index', $nailsMenu->id) : route('search.index', ['search' => 'Nails']) }}" class="category-card text-decoration-none d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift border border-light">
        <div class="category-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 45px; height: 45px;">
          <!-- Nail Polish Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c12c5d" viewBox="0 0 16 16">
            <path d="M5.5 3.5a1.5 1.5 0 0 1 1.5-1.5h2a1.5 1.5 0 0 1 1.5 1.5v3H5.5v-3zM5.5 7.5h5v2.5a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V7.5zM4.5 11h7v4.5a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5V11z"/>
            <path d="M7.5.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V1a.5.5 0 0 1 .5-.5z"/>
          </svg>
        </div>
        <div class="category-text">
          <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">Nails & Beauty</h6>
          <small class="text-pink fw-semibold" style="font-size: 0.7rem; color: #c12c5d;">Shop Now</small>
        </div>
      </a>
    </div>

    <!-- Card 5: Equipment -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="{{ $equipmentMenu ? route('browse-by-menu.index', $equipmentMenu->id) : route('search.index', ['search' => 'Equipment']) }}" class="category-card text-decoration-none d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift border border-light">
        <div class="category-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 45px; height: 45px;">
          <!-- Chair Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c12c5d" viewBox="0 0 16 16">
            <path d="M5 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5v-4zm-2 5a.5.5 0 0 1 .5-.5H4v4H3.5a.5.5 0 0 1-.5-.5v-3zM12 7a.5.5 0 0 1 .5-.5h.5v4h-.5a.5.5 0 0 1-.5-.5v-3zM6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3h-4v-3z"/>
          </svg>
        </div>
        <div class="category-text">
          <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">Equipment</h6>
          <small class="text-pink fw-semibold" style="font-size: 0.7rem; color: #c12c5d;">Shop Now</small>
        </div>
      </a>
    </div>

    <!-- Card 6: Accessories -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="{{ $accessoriesMenu ? route('browse-by-menu.index', $accessoriesMenu->id) : route('search.index', ['search' => 'Accessories']) }}" class="category-card text-decoration-none d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift border border-light">
        <div class="category-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 45px; height: 45px;">
          <!-- Bag Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c12c5d" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 0-2 2v2H5V3a3 3 0 0 1 6 0v2h-1V3a2 2 0 0 0-2-2zM4 5h8a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm0 1v8h8V6H4z"/>
          </svg>
        </div>
        <div class="category-text">
          <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">Accessories</h6>
          <small class="text-pink fw-semibold" style="font-size: 0.7rem; color: #c12c5d;">Shop Now</small>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- Adorn Products Section -->
<section class="adorn-products-section mb-4 mb-md-5">
  <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4">
    <h2 class="h3 mb-0 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">Adorn Products</h2>
  </div>
  <div class="row g-3">
    <div class="col-6 col-md-4 col-lg-3">
      <a href="{{ route('search.index', ['search' => 'EYESHADOW']) }}"
        class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift">
        <img src="https://rembekaonline.com/storage/media/wi9ZrKFdoUjUuC6x2OYOA9HBry3Y94dgd8lD0iml.jpg" alt="White Shade"
          style="max-height: 80px; max-width: 100%; object-fit: contain;" class="mb-3" />
        <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">White Shade</span>
      </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3">
      <a href="{{ route('search.index', ['search' => 'EYESHADOW']) }}"
        class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift">
        <img src="https://rembekaonline.com/storage/media/heKVqSL18pEoO1c7wb6Ni2hKjnNAov1l9XSuBJY7.jpg" alt="Pink Shade"
          style="max-height: 80px; max-width: 100%; object-fit: contain;" class="mb-3" />
        <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">Pink Shade</span>
      </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3">
      <a href="{{ route('search.index', ['search' => 'EYESHADOW']) }}"
        class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift">
        <img src="https://rembekaonline.com/storage/media/qfHgyMot9glNHlmzsa1wqcCfTAf2iBm6uavgqCWu.jpg" alt="Yellow Shade"
          style="max-height: 80px; max-width: 100%; object-fit: contain;" class="mb-3" />
        <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">Yellow Shade</span>
      </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3">
      <a href="{{ route('search.index', ['search' => 'EYESHADOW']) }}"
        class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift">
        <img src="https://rembekaonline.com/storage/media/X4ZQ6PwBcQ7mLYdWfwiK4SPxxREVsGYe4wGCUTgu.jpg" alt="Nude Shade"
          style="max-height: 80px; max-width: 100%; object-fit: contain;" class="mb-3" />
        <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">Nude Shade</span>
      </a>
    </div>
  </div>
</section>
