<section class="platform-services-section mb-4 mb-md-5">
  <div class="text-center mb-3 mb-md-4">
    <h2 class="fw-bold mb-1" style="color: #1e293b; font-size: clamp(1.2rem, 4vw, 1.6rem);">Everything Beauty, In One Place</h2>
    <p class="text-muted mb-0" style="font-size: clamp(0.8rem, 3vw, 0.95rem);">Shop products, book professionals, and access beauty services — all on Rembeka.</p>
  </div>

  <div class="row g-3">
    <!-- Product Shopping -->
    <div class="col-6 col-md-4 col-lg">
      <a href="{{ route('search.index') }}" class="platform-service-card text-decoration-none d-flex flex-column align-items-center text-center p-3 bg-white rounded-3 shadow-sm h-100 border border-light hover-lift">
        <div class="service-icon-circle mb-2 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 52px; height: 52px; flex-shrink: 0;">
          <i class="bi bi-bag-heart fs-4" style="color: #c12c5d;"></i>
        </div>
        <h6 class="fw-bold mb-1 text-dark" style="font-size: clamp(0.75rem, 2.5vw, 0.9rem);">Shop Products</h6>
        <p class="text-muted mb-0" style="font-size: clamp(0.65rem, 2vw, 0.75rem); line-height: 1.3;">Makeup, haircare, nails & more</p>
      </a>
    </div>

    <!-- Beauty Services -->
    <div class="col-6 col-md-4 col-lg">
      <a href="{{ route('stylists.index') }}" class="platform-service-card text-decoration-none d-flex flex-column align-items-center text-center p-3 bg-white rounded-3 shadow-sm h-100 border border-light hover-lift">
        <div class="service-icon-circle mb-2 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 52px; height: 52px; flex-shrink: 0;">
          <i class="bi bi-scissors fs-4" style="color: #c12c5d;"></i>
        </div>
        <h6 class="fw-bold mb-1 text-dark" style="font-size: clamp(0.75rem, 2.5vw, 0.9rem);">Beauty Services</h6>
        <p class="text-muted mb-0" style="font-size: clamp(0.65rem, 2vw, 0.75rem); line-height: 1.3;">Hair, makeup & nail services</p>
      </a>
    </div>

    <!-- Professional Bookings -->
    <div class="col-6 col-md-4 col-lg">
      <a href="{{ route('stylists.index') }}" class="platform-service-card text-decoration-none d-flex flex-column align-items-center text-center p-3 bg-white rounded-3 shadow-sm h-100 border border-light hover-lift">
        <div class="service-icon-circle mb-2 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 52px; height: 52px; flex-shrink: 0;">
          <i class="bi bi-calendar2-check fs-4" style="color: #c12c5d;"></i>
        </div>
        <h6 class="fw-bold mb-1 text-dark" style="font-size: clamp(0.75rem, 2.5vw, 0.9rem);">Book Professionals</h6>
        <p class="text-muted mb-0" style="font-size: clamp(0.65rem, 2vw, 0.75rem); line-height: 1.3;">At home or in-salon appointments</p>
      </a>
    </div>

    <!-- Beauty Equipment -->
    <div class="col-6 col-md-4 col-lg">
      <a href="{{ route('search.index', ['search' => 'Equipment']) }}" class="platform-service-card text-decoration-none d-flex flex-column align-items-center text-center p-3 bg-white rounded-3 shadow-sm h-100 border border-light hover-lift">
        <div class="service-icon-circle mb-2 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 52px; height: 52px; flex-shrink: 0;">
          <i class="bi bi-tools fs-4" style="color: #c12c5d;"></i>
        </div>
        <h6 class="fw-bold mb-1 text-dark" style="font-size: clamp(0.75rem, 2.5vw, 0.9rem);">Beauty Equipment</h6>
        <p class="text-muted mb-0" style="font-size: clamp(0.65rem, 2vw, 0.75rem); line-height: 1.3;">Professional-grade tools & gear</p>
      </a>
    </div>

    <!-- Partner Salons -->
    <div class="col-6 col-md-4 col-lg">
      <a href="{{ route('stylists.inquire') }}" class="platform-service-card text-decoration-none d-flex flex-column align-items-center text-center p-3 bg-white rounded-3 shadow-sm h-100 border border-light hover-lift">
        <div class="service-icon-circle mb-2 d-flex align-items-center justify-content-center rounded-circle" style="background-color: #fdf2f8; width: 52px; height: 52px; flex-shrink: 0;">
          <i class="bi bi-shop fs-4" style="color: #c12c5d;"></i>
        </div>
        <h6 class="fw-bold mb-1 text-dark" style="font-size: clamp(0.75rem, 2.5vw, 0.9rem);">Partner Salons</h6>
        <p class="text-muted mb-0" style="font-size: clamp(0.65rem, 2vw, 0.75rem); line-height: 1.3;">Join our growing network</p>
      </a>
    </div>
  </div>
</section>
