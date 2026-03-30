<div class="steps steps-light pt-2 pb-3 mb-5">
    <a class="step-item @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'checkout.cart' || \Illuminate\Support\Facades\Route::currentRouteName() == 'checkout.details' || \Illuminate\Support\Facades\Route::currentRouteName() == 'payment.mode') active @endif" href="{{ route('checkout.cart') }}">
        <div class="step-progress"><span class="step-count">1</span></div>
        <div class="step-label"><i class="ci-cart"></i>Cart</div>
    </a>
    
    <a class="step-item current @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'checkout.details' || \Illuminate\Support\Facades\Route::currentRouteName() == 'payment.mode') active @endif }}">
        <div class="step-progress"><span class="step-count">2</span></div>
        <div class="step-label"><i class="ci-user-circle"></i>Details</div>
    </a>
    
    <!-- <a class="step-item" href="checkout-shipping.html">
        <div class="step-progress"><span class="step-count">3</span></div>
        <div class="step-label"><i class="ci-package"></i>Shipping</div>
    </a> -->
    
    <a class="step-item @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'payment.mode') active @endif" href="#">
        <div class="step-progress"><span class="step-count">4</span></div>
        <div class="step-label"><i class="ci-card"></i>Payment</div>
    </a>
    
    <a class="step-item" href="#">
        <div class="step-progress"><span class="step-count">5</span></div>
        <div class="step-label"><i class="ci-check-circle"></i>Review</div>
    </a>
</div>