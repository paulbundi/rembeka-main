<div class="navbar navbar-expand-lg navbar-light py-2 border-bottom border-light">
    <div class="container-fluid px-md-4">
        <a class="navbar-brand d-none d-sm-block flex-shrink-0 p-0" href="{{ url('/') }}">
            <img src="{{ asset('img/logo-large.png') }}" width="150" alt="rembeka">
        </a>

        <a class="navbar-brand d-sm-none flex-shrink-0 me-2"  href="{{ url('/') }}">
            <img src="{{ asset('img/logo-large.png') }}" height="40" width="100" alt="rembeka" style="object-fit: contain;">
        </a>
        <div class="w-50 d-none d-sm-block pt-1 mx-3">
            @include('e-commerce.nav-bars.search-bar-holder')
        </div>
        <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center ms-xl-2">
            <a class="navbar-tool d-flex d-lg-none" href="#searchBox"
                data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchBox">
                <span class="navbar-tool-tooltip">Search</span>
                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-search"></i></div>
            </a>
            <a class="navbar-tool d-none d-sm-block me-3" href="{{ route('wishlists.index') }}">
                <div class="navbar-tool-icon-box position-relative bg-transparent border-0">
                    <i class="navbar-tool-icon ci-heart text-dark fs-5"></i>
                    @if(auth()->check() && auth()->user()->liked  > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            {{ auth()->user()->liked }}
                        </span>
                    @endif
                </div>
            </a>

            <div class="me-3">
                <cart-hover />
            </div>

            <a class="navbar-tool ms-1" @if(auth()->guest()) href="{{ route('login') }}" @else  href="{{ route('profile.index') }}" @endif>
                <div class="navbar-tool-icon-box bg-transparent border-0">
                    <i class="navbar-tool-icon ci-user text-dark fs-5"></i>
                </div>
                <div class="navbar-tool-text ms-2 lh-1 text-start">
                    <small class="text-muted d-block" style="font-size: 0.7rem;">Hello, @if(auth()->check()) {{ auth()->user()->first_name }} @else Angela @endif</small>
                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">My Account</span>
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

@include('e-commerce.nav-bars.horizontal-menu-bar')


