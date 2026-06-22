@extends('layouts.e-commerce')

@section('seo')
@include('layouts.common-seo')
@endSection

@section('content')
<main style="padding-top: 3.5rem;">
  <section class="px-3 px-md-4">

    {{-- 1. Hero --}}
    @include('e-commerce.sliders.welcome-slider')

    {{-- 2. Platform Services --}}
    @include('e-commerce.platform-services')

    {{-- 3. How It Works --}}
    @include('e-commerce.how-it-works')

    {{-- 4. Category Grid --}}
    @include('e-commerce.categories-grid')

    {{-- 5. Trust Badges --}}
    @include('e-commerce.trust-badges')

    {{-- 6. Social Proof / Stats --}}
    @include('e-commerce.social-proof')

    {{-- 7. Best Sellers --}}
    @include('e-commerce.sliders.best-seller')

    {{-- 8. Special Offers --}}
    @include('e-commerce.special-offers')

    {{-- 9. Discounted Products --}}
    @include('e-commerce.sliders.discouted-products')

    {{-- 10. Meet Our Stylists --}}
    @if(isset($stylists) && $stylists->count() > 0)
      @include('e-commerce.sliders.meet-our-stylist')
    @endif

    {{-- 11. Partners --}}
    @include('e-commerce.sliders.our-partners')

    {{-- 12. Footer Pink Bar --}}
    @include('e-commerce.footer-pink-bar')

    {{-- 13. Footer --}}
    @include('layouts.e-commerce-footer')

  </section>
</main>

@if(isset($activeAd) && $activeAd != null)
<div class="modal fade" id="advertModal" tabindex="-1" aria-labelledby="advertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-0">
        <img class="rounded w-100" src="{{ optional(optional($activeAd->attachments->first())->media)->url }}" style="max-height:70vh; object-fit:contain;" />
      </div>
      <div class="modal-footer">
        <input type="checkbox" id="permentenly-hide-modal" name="hidemodal">
        <small>Don't show again</small>
        <a href="{{ $activeAd->call_to_action_url }}" id="per" class="btn btn-primary">{{ $activeAd->call_to_action }}</a>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('scripts')
<script>
  let isModalVisible = localStorage.getItem("adModalIsVisible");
  const advertModal = document.getElementById('advertModal');

  if (!isModalVisible && advertModal) {
    const myModal = new bootstrap.Modal(advertModal, {})
    myModal.show();
  }

  $('#permentenly-hide-modal').click(function(e) {
    if (e.target.value == 'on') {
      localStorage.setItem("adModalIsVisible", true);
    }
  });
</script>
@endpush
