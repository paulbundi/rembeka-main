<section class="partners-section pt-4 pb-4 text-center">
  <!-- Heading-->
  <div class="d-flex justify-content-center border-bottom pb-2 mb-4">
    <h2 class="h3 mb-0 pt-3 text-uppercase fw-bold text-center" style="color: #1e293b; letter-spacing: 0.5px;">Partner
      Brands</h2>
  </div>

  @if(($partners ?? collect())->isNotEmpty())
    <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled pt-2">
      <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "gutter": 16, "controls": true, "autoHeight": true, "responsive": {"0":{"items":1}, "480":{"items":2}, "720":{"items":3}, "991":{"items":2}, "1140":{"items":3}, "1300":{"items":4}, "1500":{"items":5}}}'>
        @foreach($partners as $partner)
          @include('e-commerce.partials.partner-card', ['partner' => $partner])
        @endforeach
      </div>
    </div>

    <div class="mt-4">
      <a href="{{ route('brands.index') }}" class="btn btn-primary btn-shadow">
        View All Partner Brands
      </a>
    </div>
  @endif
</section>
