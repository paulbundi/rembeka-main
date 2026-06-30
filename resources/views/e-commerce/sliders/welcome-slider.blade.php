<section class="hero-section mb-4 mb-md-5 py-4 py-md-5 rounded-3 overflow-hidden text-center text-md-start"
  style="background: linear-gradient(135deg, #c12c5d 0%, #a0204c 100%);">
  <div class="container-fluid px-3 px-sm-4 px-md-5">
    <div class="tns-carousel tns-controls-static tns-controls-outside tns-dots-enabled" role="region"
      aria-label="Hero slider">
      <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 1, &quot;gutter&quot;: 0, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;nav&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 7000}">



        {{-- Slide 1: Search / Products --}}
        <div class="position-relative">
          <div class="position-absolute top-0 end-0 p-3" style="z-index: 2;">
            <img src="{{ asset('img/logo-large.png') }}" width="120" alt="rembeka">
          </div>

          <div class="row align-items-center">
            <div class="col-12 col-md-6 col-lg-5 text-white mb-3 mb-md-0">
              <p class="text-white opacity-75 mb-1 fw-semibold text-uppercase"
                style="font-size: clamp(0.65rem, 2vw, 0.75rem); letter-spacing: 1.5px;">Kenya's Beauty Platform</p>
              <h1 class="fw-bold text-white mb-2 lh-1"
                style="font-family: 'Outfit', sans-serif; font-size: clamp(1.8rem, 6vw, 3rem);">
                Beauty made<br><span style="font-style: italic; font-weight: 300;">simple.</span>
              </h1>
              <p class="opacity-90 mb-3 fw-light" style="font-size: clamp(0.85rem, 3vw, 1rem);">Shop authentic beauty
                products, book trusted professionals, and access beauty services — all in one place.</p>
              <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                <a href="{{ route('search.index') }}" class="btn btn-dark px-3 py-2 border-0 shadow-sm"
                  style="background-color:#0f172a; border-radius:8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight:600;">
                  <i class="bi bi-bag me-1"></i> Shop Now
                </a>
                <a href="{{ route('stylists.index') }}" class="btn btn-outline-light px-3 py-2"
                  style="border-radius:8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight:600;">
                  <i class="bi bi-calendar2-check me-1"></i> Book a Service
                </a>
              </div>
            </div>

            <div
              class="col-12 col-md-6 col-lg-7 d-flex justify-content-center justify-content-md-end position-relative py-3">
              <div class="hero-circles-wrapper">
<a href="{{ route('search.index', ['search' => 'Hair']) }}" class="text-decoration-none">
                   <div class="hero-circle circle-hair">
                     <div class="circle-img-holder" style="background-image:url('{{ asset('img/hero_hair.png') }}');">
                     </div>
                     <div class="circle-badge">Hair</div>
                   </div>
                 </a>
                <a href="{{ route('search.index', ['search' => 'Makeup']) }}" class="text-decoration-none">
                  <div class="hero-circle circle-makeup">
                    <div class="circle-img-holder"
                      style="background-image:url('https://rembekaonline.com/storage/media/KtYKAaxW3afTRJU5epK9sJUXYBXwrZQK8KIHK1XH.png');">
                    </div>
                    <div class="circle-badge">Makeup</div>
                  </div>
                </a>
                <a href="{{ route('search.index', ['search' => 'Nails']) }}" class="text-decoration-none">
                  <div class="hero-circle circle-nails">
                    <div class="circle-img-holder" style="background-image:url('{{ asset('img/hero_nails.png') }}');">
                    </div>
                    <div class="circle-badge">Nails</div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        {{-- Slide 2: Best sellers / 15% off Adorn --}}
        <div class="position-relative">
          <div class="position-absolute top-0 end-0 p-3" style="z-index: 2;">
            <img src="{{ asset('img/logo-large.png') }}" width="120" alt="rembeka">
          </div>

          <div class="row align-items-center">
            <div class="col-12 col-md-6 col-lg-5 text-white mb-3 mb-md-0">
              <p class="text-white opacity-75 mb-1 fw-semibold text-uppercase"
                style="font-size: clamp(0.65rem, 2vw, 0.75rem); letter-spacing: 1.5px;">Best sellers</p>
              <h2 class="fw-bold text-white mb-2"
                style="font-family:'Outfit', sans-serif; font-size: clamp(1.4rem, 5vw, 2.5rem);">15% off Adorn picks
              </h2>
              <p class="opacity-90 mb-3 fw-light" style="font-size: clamp(0.85rem, 3vw, 1rem);">Shop top-rated Adorn
                products while they’re discounted.</p>
              <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                <a href="{{ route('search.index') }}" class="btn btn-dark px-3 py-2 border-0 shadow-sm"
                  style="background-color:#0f172a; border-radius:8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight:600;">
                  <i class="bi bi-bag me-1"></i> Browse products
                </a>
              </div>
            </div>

            <div
              class="col-12 col-md-6 col-lg-7 d-flex justify-content-center justify-content-md-end position-relative py-3">
              <div class="hero-circles-wrapper">
                <a href="{{ route('search.index', ['search' => 'Adorn']) }}" class="text-decoration-none">
                  <div class="hero-circle circle-hair">
                    <div class="circle-img-holder"
                      style="background-image:url('https://rembekaonline.com/storage/media/1iTURB8EYEjc0ihYvksk56OL3z09AjTECZkMqFBQ.png');">
                    </div>
                    <div class="circle-badge">Adorn</div>
                  </div>
                </a>
                <a href="{{ route('search.index', ['search' => 'Adorn Glow']) }}" class="text-decoration-none">
                  <div class="hero-circle circle-makeup">
                    <div class="circle-img-holder"
                      style="background-image:url('https://rembekaonline.com/storage/media/KtYKAaxW3afTRJU5epK9sJUXYBXwrZQK8KIHK1XH.png');">
                    </div>
                    <div class="circle-badge">Glow</div>
                  </div>
                </a>
                <a href="{{ route('search.index', ['search' => 'Adorn Care']) }}" class="text-decoration-none">
                  <div class="hero-circle circle-nails">
                    <div class="circle-img-holder" style="background-image:url('{{ asset('img/hero_nails.png') }}');">
                    </div>
                    <div class="circle-badge">Care</div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        {{-- Slide 3: Professionals --}}
        <div class="position-relative">
          <div class="position-absolute top-0 end-0 p-3" style="z-index: 2;">
            <img src="{{ asset('img/logo-large.png') }}" width="120" alt="rembeka">
          </div>

          <div class="row align-items-center">
            <div class="col-12 col-md-6 col-lg-5 text-white mb-3 mb-md-0">
              <p class="text-white opacity-75 mb-1 fw-semibold text-uppercase"
                style="font-size: clamp(0.65rem, 2vw, 0.75rem); letter-spacing: 1.5px;">Professionals</p>
              <h2 class="fw-bold text-white mb-2"
                style="font-family:'Outfit', sans-serif; font-size: clamp(1.4rem, 5vw, 2.5rem);">Book trusted experts
              </h2>
              <p class="opacity-90 mb-3 fw-light" style="font-size: clamp(0.85rem, 3vw, 1rem);">Schedule appointments
                with verified stylists.</p>
              <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                <a href="{{ route('stylists.index') }}" class="btn btn-dark px-3 py-2 border-0 shadow-sm"
                  style="background-color:#0f172a; border-radius:8px; font-size: clamp(0.8rem, 2.5vw, 0.9rem); font-weight:600;">
                  <i class="bi bi-calendar2-check me-1"></i> Book a stylist
                </a>
              </div>
            </div>

            <div
              class="col-12 col-md-6 col-lg-7 d-flex justify-content-center justify-content-md-end position-relative py-3">
              <div class="hero-circles-wrapper">
                <a href="{{ route('stylists.index') }}" class="text-decoration-none">
                  <div class="hero-circle circle-hair">
                    <div class="circle-img-holder" style="background-image:url('{{ asset('img/hero_hair.png') }}');">
                    </div>
                    <div class="circle-badge">Hair</div>
                  </div>
                </a>
                <a href="{{ route('stylists.index') }}" class="text-decoration-none">
                  <div class="hero-circle circle-makeup">
                    <div class="circle-img-holder" style="background-image:url('{{ asset('img/hero_makeup.png') }}');">
                    </div>
                    <div class="circle-badge">Makeup</div>
                  </div>
                </a>
                <a href="{{ route('stylists.index') }}" class="text-decoration-none">
                  <div class="hero-circle circle-nails">
                    <div class="circle-img-holder" style="background-image:url('{{ asset('img/hero_nails.png') }}');">
                    </div>
                    <div class="circle-badge">Nails</div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>