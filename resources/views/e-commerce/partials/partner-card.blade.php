@php
  $media = $partner->logo;
@endphp

<div class="col-6 col-md-4 col-lg-3">
  <div class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift">
    @if($media && $media->url)
      <img src="{{ asset($media->url) }}" alt="{{ $partner->name }}"
        style="max-height: 60px; max-width: 100%; object-fit: contain;" class="mb-3" />
    @endif
    <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">{{ $partner->name }}</span>
  </div>
</div>
