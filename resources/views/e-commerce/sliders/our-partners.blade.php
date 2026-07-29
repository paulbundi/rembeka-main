<section class="partners-section pt-4 pb-4 text-center">
  <!-- Heading-->
  <div class="d-flex justify-content-center border-bottom pb-2 mb-4">
    <h2 class="h3 mb-0 pt-3 text-uppercase fw-bold text-center" style="color: #1e293b; letter-spacing: 0.5px;">Partner
      Brands</h2>
  </div>

  @if(($brands ?? collect())->isNotEmpty())
    <div class="row g-4 justify-content-center">
      @foreach($brands as $brand)
        @php
          $media = optional(optional($brand->attachments->first())->media);
        @endphp
        <div class="col-6 col-md-5 col-lg-4">
          <a href="{{ route('search.index', ['search' => $brand->name]) }}"
            class="text-decoration-none">
            <div class="card border-0 bg-white shadow-sm h-100 hover-lift">
              <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                @if($media && $media->url)
                  <img src="{{ asset($media->url) }}" alt="{{ $brand->name }}"
                    class="img-fluid partner-card-img"
                    style="max-height: 120px; object-fit: contain; transition: transform 0.3s ease;">
                @endif
                <p class="fw-bold text-dark mt-3 mb-0 text-center">{{ $brand->name }}</p>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>

    <div class="mt-4">
      <a href="{{ route('brands.index') }}" class="btn btn-primary btn-shadow">
        View All Brands
      </a>
    </div>
  @endif
</section>
