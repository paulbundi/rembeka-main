<div class="navbar navbar-expand-lg navbar-light pb-0">
    <div class="container-fluid">
        <a class="navbar-brand d-none d-sm-block flex-shrink-0 p-0" href="{{ url('/') }}">
            <img src="{{ asset('img/logo-large.png') }}" width="140" alt="rembeka">
        </a>

        <a class="navbar-brand d-sm-none flex-shrink-0 me-2"  href="{{ url('/') }}">
            <img src="{{ asset('img/logo-large.png') }}" height="50" width="60" alt="rembeka">
        </a>
        <div class="w-50 d-none d-sm-block pt-2">
            @include('e-commerce.nav-bars.search-bar-holder')
        </div>
        <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center ms-xl-2">
            <a class="navbar-tool d-flex d-lg-none" href="#searchBox"
                data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchBox">
                <span class="navbar-tool-tooltip">Search</span>
                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-search"></i></div>
            </a>
            <a class="navbar-tool d-none d-sm-block shopping-cart navbar-tool-icon-box bg-secondary dropdown-toggle shopping-cart" href="{{ route('wishlists.index') }}">
                @if(auth()->check() && auth()->user()->liked  > 0)
                    <span class="navbar-tool-label">{{ auth()->user()->liked }}</span>
                @endif
                <span class="navbar-tool-tooltip">Wishlist</span>
                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-heart"></i></div>
            </a>

            <div>
                <cart-hover />
            </div>

            <a class="navbar-tool ms-3" @if(auth()->guest()) href="{{ route('login') }}" @else  href="{{ route('profile.index') }}" @endif>
                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user"></i></div>
                <div class="navbar-tool-text ms-n3">
                    <small>Hello, @if(auth()->check()) {{ auth()->user()->first_name }} @else Sign in @endif</small>
                    My Account
                </div>
            </a>

            
        </div>
    </div>
</div>
<!-- Search collapse-->
<div class="collapse" id="searchBox">
    <div class="card pt-2 pb-4 border-0 rounded-0 mx-2">
         @include('e-commerce.nav-bars.search-bar-holder')
    </div>
</div>


