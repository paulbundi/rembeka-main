<section class="special-offers-section mb-4 mb-md-5" id="offers">
  <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-2 mb-4">
    <h2 class="h3 mb-0 pt-3 me-3 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">Special Offers</h2>
    <div class="pt-3">
      <a class="btn btn-sm hover-pink-text fw-bold text-decoration-none" href="{{ route('filter.index') }}" style="color: #c12c5d;">
        View all <i class="ci-arrow-right ms-1"></i>
      </a>
    </div>
  </div>

  <div class="row g-4">
    <!-- Card 1: 20% OFF Lip Products -->
    <div class="col-12 col-md-4">
      <div class="promo-card d-flex align-items-center justify-content-between p-4 rounded-3 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffe4e6 0%, #fecdd3 100%); min-height: 180px;">
        <div class="promo-content zindex-1 text-start" style="max-width: 60%;">
          <h3 class="display-6 fw-bold mb-1" style="color: #be123c; font-size: 1.8rem;">20%<br><span style="font-size: 1.2rem; font-weight: 800;">OFF</span></h3>
          <p class="fs-sm fw-medium text-slate mb-3" style="color: #475569; font-size: 0.85rem; line-height: 1.2;">On Adorn<br>Lip Products</p>
          <a href="{{ route('search.index', ['search' => 'Lip']) }}" class="btn btn-sm btn-pink text-white border-0 px-3 hover-lift" style="background-color: #c12c5d; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
            Shop Now
          </a>
        </div>
        <div class="promo-image-holder position-absolute end-0 bottom-0" style="width: 45%; height: 95%; background-image: url('{{ asset('img/promo_lips.png') }}'); background-size: contain; background-position: right bottom; background-repeat: no-repeat;"></div>
      </div>
    </div>

    <!-- Card 2: 15% OFF Haircare Products -->
    <div class="col-12 col-md-4">
      <div class="promo-card d-flex align-items-center justify-content-between p-4 rounded-3 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); min-height: 180px;">
        <div class="promo-content zindex-1 text-start" style="max-width: 60%;">
          <h3 class="display-6 fw-bold mb-1" style="color: #b45309; font-size: 1.8rem;">15%<br><span style="font-size: 1.2rem; font-weight: 800;">OFF</span></h3>
          <p class="fs-sm fw-medium text-slate mb-3" style="color: #475569; font-size: 0.85rem; line-height: 1.2;">On All Haircare<br>Products</p>
          <a href="{{ route('search.index', ['search' => 'Hair']) }}" class="btn btn-sm btn-pink text-white border-0 px-3 hover-lift" style="background-color: #c12c5d; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
            Shop Now
          </a>
        </div>
        <div class="promo-image-holder position-absolute end-0 bottom-0" style="width: 45%; height: 95%; background-image: url('{{ asset('img/promo_hair.png') }}'); background-size: contain; background-position: right bottom; background-repeat: no-repeat;"></div>
      </div>
    </div>

    <!-- Card 3: Up to 30% OFF Equipment -->
    <div class="col-12 col-md-4">
      <div class="promo-card d-flex align-items-center justify-content-between p-4 rounded-3 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fae8ff 0%, #f5d0fe 100%); min-height: 180px;">
        <div class="promo-content zindex-1 text-start" style="max-width: 60%;">
          <h3 class="display-6 fw-bold mb-1" style="color: #a21caf; font-size: 1.8rem;"><span style="font-size: 0.85rem; font-weight: 800; display: block; margin-bottom: -5px;">UP TO</span>30%<br><span style="font-size: 1.2rem; font-weight: 800;">OFF</span></h3>
          <p class="fs-sm fw-medium text-slate mb-3" style="color: #475569; font-size: 0.85rem; line-height: 1.2;">On Beauty<br>Equipment</p>
          <a href="{{ route('search.index', ['search' => 'Equipment']) }}" class="btn btn-sm btn-pink text-white border-0 px-3 hover-lift" style="background-color: #c12c5d; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
            Shop Now
          </a>
        </div>
        <div class="promo-image-holder position-absolute end-0 bottom-0" style="width: 45%; height: 95%; background-image: url('{{ asset('img/promo_equip.png') }}'); background-size: contain; background-position: right bottom; background-repeat: no-repeat;"></div>
      </div>
    </div>
  </div>
</section>
