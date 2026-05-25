@php
    $route = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<div class="steps steps-light pt-2 pb-3 mb-5">

    {{-- STEP 1 --}}
    <a class="step-item {{ in_array($route, ['checkout.cart', 'checkout.details', 'payment.mode']) ? 'active' : '' }}"
        href="{{ route('checkout.cart') }}">
        <div class="step-progress"><span class="step-count">1</span></div>
        <div class="step-label"><i class="ci-cart"></i>Cart</div>
    </a>

    {{-- STEP 2 --}}
    <a class="step-item {{ in_array($route, ['checkout.details', 'payment.mode']) ? 'active' : '' }}">
        <div class="step-progress"><span class="step-count">2</span></div>
        <div class="step-label"><i class="ci-user-circle"></i>Details</div>
    </a>

    {{-- STEP 3 (optional - shipping skipped) --}}

    {{-- STEP 4 --}}
    <a class="step-item {{ $route == 'payment.mode' ? 'active' : '' }}">
        <div class="step-progress"><span class="step-count">4</span></div>
        <div class="step-label"><i class="ci-card"></i>Payment</div>
    </a>

    {{-- STEP 5 --}}
    <a class="step-item">
        <div class="step-progress"><span class="step-count">5</span></div>
        <div class="step-label"><i class="ci-check-circle"></i>Review</div>
    </a>

</div>