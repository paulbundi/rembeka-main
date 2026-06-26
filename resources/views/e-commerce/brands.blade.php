@extends('layouts.e-commerce')

@section('seo')
@include('layouts.common-seo')
@endSection

@section('content')
<main style="padding-top: 3.5rem;">
  <section class="px-3 px-md-4 py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-2 mb-4">
      <h2 class="h3 mb-0 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">Brands</h2>
    </div>

    <div class="row g-3">
      @foreach($brands as $brand)
        <div class="col-6 col-md-4 col-lg-3">
          <a href="{{ route('search.index', ['search' => $brand->name]) }}"
            class="text-decoration-none d-flex flex-column align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm border border-light h-100 hover-lift">
            @php
              $media = optional(optional($brand->attachments->first())->media);
            @endphp
            @if($media && $media->url)
              <img src="{{ asset($media->url) }}" alt="{{ $brand->name }}"
                style="max-height: 60px; max-width: 100%; object-fit: contain;" class="mb-3" />
            @endif
            <span class="fw-bold text-dark text-center" style="font-size: 0.9rem;">{{ $brand->name }}</span>
          </a>
        </div>
      @endforeach
    </div>
  </section>
</main>
@endsection
