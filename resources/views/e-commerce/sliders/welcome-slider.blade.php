<section class="hero-section mb-4 mb-md-5 py-5 rounded-3 overflow-hidden text-center text-md-start" style="background: linear-gradient(135deg, #c12c5d 0%, #a0204c 100%);">
  <div class="container px-4 px-sm-5 mx-auto">
    <div class="row align-items-center">
      <!-- Left Content -->
      <div class="col-12 col-md-6 col-lg-5 text-white mb-4 mb-md-0">
        <h1 class="display-4 fw-bold text-white mb-2 lh-1" style="font-family: 'Outfit', sans-serif;">
          Beauty made<br><span class="italic-title" style="font-style: italic; font-weight: 300;">simple.</span>
        </h1>
        <p class="fs-5 opacity-90 mb-4 fw-light">
          Premium products. Professional services.<br>All in one place.
        </p>
        <a href="{{ route('filter.index') }}" class="btn btn-dark btn-lg px-4 py-2 border-0 shadow-sm hover-lift" style="background-color: #0f172a; border-radius: 8px; font-size: 0.95rem; font-weight: 600;">
          Shop Now
        </a>
      </div>

      <!-- Right Content - Overlapping Circles -->
      <div class="col-12 col-md-6 col-lg-7 d-flex justify-content-center justify-content-md-end position-relative py-3">
        <div class="hero-circles-wrapper">
          <!-- Circle 1: Hair -->
          <div class="hero-circle circle-hair">
            <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_hair.png') }}');"></div>
            <div class="circle-badge">Hair</div>
          </div>
          <!-- Circle 2: Makeup -->
          <div class="hero-circle circle-makeup">
            <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_makeup.png') }}');"></div>
            <div class="circle-badge">Makeup</div>
          </div>
          <!-- Circle 3: Nails -->
          <div class="hero-circle circle-nails">
            <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_nails.png') }}');"></div>
            <div class="circle-badge">Nails</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>