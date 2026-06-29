<section class="mb-4 mb-md-5">
  <div class="tns-carousel tns-controls-static tns-controls-outside tns-dots-enabled" aria-label="Rembeka hero slider">
    <div class="tns-carousel-inner" data-carousel-options="{" items": 1, "gutter" : 0, "controls" : true, "autoHeight" :
      true, "autoplay" : true, "autoplayTimeout" : 5500}">

      <!-- Slide 1 -->
      <div>
        <section class="hero-section py-4 py-md-5 rounded-3 overflow-hidden text-center text-md-start"
          style="background: linear-gradient(135deg, #c12c5d 0%, #a0204c 100%);">
          <div class="container-fluid px-3 px-sm-4 px-md-5">
            <div class="row align-items-center position-relative">
              <div class="position-absolute top-0 end-0 p-3">
                <img src="{{ asset('img/logo-large.png') }}" alt="rembeka"
                  style="height: 44px; width: auto; object-fit: contain;" />
              </div>

              <!-- Left Content -->
              <div class="col-12 col-md-6 col-lg-5 text-white mb-3 mb-md-0">
                <p class="text-white opacity-75 mb-1 fw-semibold text-uppercase"
                  style="font-size: clamp(0.65rem, 2vw, 0.75rem); letter-spacing: 1.5px;">Kenya's Beauty Platform</p>
                <h1 class="fw-bold text-white mb-2 lh-1"
                  style="font-family: 'Outfit', sans-serif; font-size: clamp(1.8rem, 6vw, 3rem);">
                  Beauty made<br><span style="font-style: italic; font-weight: 300;">simple.</span>
                </h1>
                <p class="opacity-90 mb-3 fw-light" style="font-size: clamp(0.85rem, 3vw, 1rem);">
                  Shop authentic beauty products and get delivery — all in one place.
                </p>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                  <a href="{{ route('search.index') }}" class="btn btn-dark px-3 py-2 border-0 shadow-sm"
                    style="background-color: #0f172a; border-radius: 8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                    <i class="bi bi-bag me-1"></i> Shop Now
                  </a>
                  <a href="{{ route('stylists.index') }}" class="btn btn-outline-light px-3 py-2"
                    style="border-radius: 8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                    <i class="bi bi-calendar2-check me-1"></i> Book a Service
                  </a>
                </div>
              </div>

              <!-- Right Content - Product Images -->
              <div
                class="col-12 col-md-6 col-lg-7 d-flex justify-content-center justify-content-md-end position-relative py-3">
                <div class="hero-circles-wrapper">
                  <div class="hero-circle circle-hair">
                    <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_hair.png') }}');">
                    </div>
                    <div class="circle-badge">Hair</div>
                  </div>
                  <div class="hero-circle circle-makeup">
                    <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_makeup.png') }}');">
                    </div>
                    <div class="circle-badge">Makeup</div>
                  </div>
                  <div class="hero-circle circle-nails">
                    <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_nails.png') }}');">
                    </div>
                    <div class="circle-badge">Nails</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Slide 2 -->
      <div>
        <section class="hero-section py-4 py-md-5 rounded-3 overflow-hidden text-center text-md-start"
          style="background: linear-gradient(135deg, #c12c5d 0%, #8b1d38 100%);">
          <div class="container-fluid px-3 px-sm-4 px-md-5">
            <div class="row align-items-center position-relative">
              <div class="position-absolute top-0 end-0 p-3">
                <img src="{{ asset('img/logo-large.png') }}" alt="rembeka"
                  style="height: 44px; width: auto; object-fit: contain;" />
              </div>

              <div class="col-12 col-md-6 col-lg-5 text-white mb-3 mb-md-0">
                <p class="text-white opacity-75 mb-1 fw-semibold text-uppercase"
                  style="font-size: clamp(0.65rem, 2vw, 0.75rem); letter-spacing: 1.5px;">Shop curated favorites</p>
                <h1 class="fw-bold text-white mb-2 lh-1"
                  style="font-family: 'Outfit', sans-serif; font-size: clamp(1.6rem, 5.5vw, 2.8rem);">
                  New deals<br><span style="font-style: italic; font-weight: 300;">every day.</span>
                </h1>
                <p class="opacity-90 mb-3 fw-light" style="font-size: clamp(0.85rem, 3vw, 1rem);">
                  Get 15% off on Adorn best sellers today.
                </p>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                  <a href="{{ route('search.index') }}" class="btn btn-dark px-3 py-2 border-0 shadow-sm"
                    style="background-color: #0f172a; border-radius: 8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight: 600;">
                    <i class="bi bi-bag me-1"></i> Discover deals
                  </a>
                </div>
              </div>

              <div
                class="col-12 col-md-6 col-lg-7 d-flex justify-content-center justify-content-md-end position-relative py-3">
                <div class="hero-circles-wrapper">
                  <div class="hero-circle circle-hair">
                    <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_makeup.png') }}');">
                    </div>
                    <div class="circle-badge">Makeup</div>
                  </div>
                  <div class="hero-circle circle-makeup">
                    <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_nails.png') }}');">
                    </div>
                    <div class="circle-badge">Nails</div>
                  </div>
                  <div class="hero-circle circle-nails">
                    <div class="circle-img-holder" style="background-image: url('{{ asset('img/hero_hair.png') }}');">
                    </div>
                    <div class="circle-badge">Hair</div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>

    </div>
  </div>
</section>