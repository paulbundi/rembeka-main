@extends('layouts.e-commerce')

@section('seo')
@include('layouts.common-seo')
@endsection

@section('content')
<main style="padding-top: 3.5rem;">
  <section class="px-3 px-md-4 py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-2 mb-4">
      <h2 class="h3 mb-0 text-uppercase fw-bold" style="color: #1e293b; letter-spacing: 0.5px;">Partner Brands</h2>
    </div>

    <div class="row g-3">
      @foreach($partners as $partner)
        @include('e-commerce.partials.partner-card', ['partner' => $partner])
      @endforeach
    </div>
  </section>
</main>
@endsection
