<aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
    <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
        <div class="d-flex flex-row justify-content-between">
            <div class="d-flex flex-row ps-2 my-2">
                <div class="ps-2">
                    <user-icon :user="{{auth()->user()}}" size="avatar-md"></user-icon>
                </div>
                <div class="ms-1">
                    <b>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</b><br/>
                    <span class="text-accent fs-sm">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <div class="pt-2">
                <a class="btn btn-dark d-lg-none" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="ci-menu me-2"></i>
                </a>
            </div>

        </div>
    </div>

    <div class="d-lg-block card bg-white collapse" id="account-menu">
        <div class="bg-secondary px-4 py-3">
            <h3 class="fs-sm mb-0 text-muted">Dashboard</h3>
        </div>
        <ul class="list-unstyled mb-0">
            @if(auth()->user()->account_type == \App\Models\User::TYPE_PROVIDER)
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('service-requests.index') }}"><i class="ci-bag opacity-60 me-2"></i>Service Request</a></li>
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('book-slots.index') }}"><i class="ci-time opacity-60 me-2"></i>Reserve a Slot</a></li>
            @endif
            @if(auth()->user()->account_type == \App\Models\User::TYPE_DRIVER)
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('delivery-requests.index') }}">
                    <i class="ci-bag opacity-60 me-2"></i>Service Request</a>
                </li>
            @endif
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('orders.index') }}"><i class="ci-bag opacity-60 me-2"></i>Orders</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('wishlists.index') }}"><i class="ci-heart opacity-60 me-2"></i>Wishlist</a></li>
            <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('tickets.index') }}"><i class="ci-help opacity-60 me-2"></i>Support tickets</a></li>
        </ul>
        <div class="bg-secondary px-4 py-3">
            <h3 class="fs-sm mb-0 text-muted">Account settings</h3>
        </div>
        <ul class="list-unstyled mb-0">
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('profile.index') }}"><i class="ci-user opacity-60 me-2"></i>Profile info</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('addresses.index')}}"><i class="ci-location opacity-60 me-2"></i>Addresses</a></li>
            <li class="border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('user.logout')}}"><i class="ci-sign-out opacity-60 me-2"></i>Sign out</a></li>
        </ul>
    </div>
</aside>