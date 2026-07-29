@php
  $media = $partner->logo;
@endphp

<div class="col-6 col-md-4 col-lg-3">
  <a href="{{ $partner->callback_url ?: route('search.index', ['search' => $partner->name]) }}"
    class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift"
    @if($partner->callback_url) target="_blank" rel="noopener" @endif>
    @if($media && $media->url)
      <img src="{{ asset($media->url) }}" alt="{{ $partner->name }}"
        style="max-height: 60px; max-width: 100%; object-fit: contain;" class="mb-3" />
    @endif
    <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">{{ $partner->name }}</span>
  </a>
</div>
