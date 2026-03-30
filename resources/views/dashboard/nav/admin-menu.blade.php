	
@if(canAccess('inquiries.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('inquiries.index') }}">
            <i class="bi bi-cart-fill"></i>
            <span class="align-middle">inquiries</span>
        </a>
    </li>
@endif

@if(canAccess('sales.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('sales.index') }}">
            <i class="bi bi-bar-chart-line-fill"></i>
            <span class="align-middle">Sales</span>
        </a>
    </li>
@endif

@if(canAccess('orders.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system-orders.index') }}">
            <i class="bi bi-gift"></i><span class="align-middle">Orders</span>
        </a>
    </li>
@endif


@if(canAccess('transport-requests.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('transport-requests.index') }}">
            <i class="bi bi-taxi-front-fill"></i>
            </i><span class="align-middle">Trsport Request</span>
        </a>
    </li>
@endif

@if(canAccess('delivery-requests.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('product-delivery-requests.index') }}">
            <i class="bi bi-truck"></i>
            <span class="align-middle">Delivery Request</span>
        </a>
    </li>
@endif

@if(canAccess('wishlist.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('wish-list.index') }}">
        <i class="bi bi-heart"></i>
            <span class="align-middle">Wishlist</span>
        </a>
    </li>
@endif

@if(canAccess('customer-review.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('customer-reviews.index') }}">
        <i class="bi bi-cup-hot-fill"></i>
            <span class="align-middle">Review</span>
        </a>
    </li>
@endif

@if(canAccess('bulk-update.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('bulk-update.merchandise') }}">
        <i class="bi bi-cloud-upload"></i>
        <span class="align-middle">Merchandise</span>
        </a>
    </li>
@endif


@if(canAccess('modules.product-setting'))
    <li class="sidebar-header">Product Settings</li>

    @if(canAccess('products.view'))
        <li class="sidebar-item">
            <a class="sidebar-link"  href="{{ route('products.index') }}">
            <i class="bi bi-box"></i> <span class="align-middle">Products</span>
            </a>
        </li>
    @endif

    @if(canAccess('products.view'))
        <li class="sidebar-item">
            <a class="sidebar-link"  href="{{ route('product-pricings.index') }}">
            <i class="bi bi-currency-exchange"></i> <span class="align-middle">Product Pricing</span>
            </a>
        </li>
    @endif

    @if(canAccess('suppliers.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('suppliers.index') }}">
                <i class="bi bi-truck"></i><span class="align-middle">Suppliers</span>
            </a>
        </li>
    @endif

    @if(canAccess('drivers.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('drivers.index') }}">
                <i class="bi bi-truck"></i><span class="align-middle">Riders</span>
            </a>
        </li>
    @endif


    @if(canAccess('brands.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('brands.index') }}">
                <i class="bi bi-dice-5"></i><span class="align-middle">Brands</span>
            </a>
        </li>
    @endif

    @if(canAccess('discounts.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('product-discounts.index') }}">
                <i class="bi bi-bag-heart"></i><span class="align-middle">Product Discount</span>
            </a>
        </li>
    @endif

    @if(canAccess('unit-measures.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('unit-measures.index') }}">
                <i class="bi bi-rulers"></i><span class="align-middle">Unit Of Measure</span>
            </a>
        </li>
    @endif

@endif

@if(canAccess('modules.service-settings'))
<li class="sidebar-header">Service Settings</li>


@if(canAccess('services.view'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('services.index') }}">
        <i class="bi bi-box"></i> <span class="align-middle">Services</span>
        </a>
    </li>
@endif

@if(canAccess('services.import'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('import-products.index') }}">
        <i class="bi bi-mailbox2"></i> <span class="align-middle">Import Services</span>
        </a>
    </li>
@endif

@if(canAccess('services.view'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('service-pricings.index') }}">
        <i class="bi bi-cash-coin"></i> <span class="align-middle">Service Pricing</span>
        </a>
    </li>
@endif

@if(canAccess('services.view'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('best-sellers.index') }}">
        <i class="bi bi-receipt"></i><span class="align-middle">Best Sellers</span>
        </a>
    </li>
@endif

@if(canAccess('services.view'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('service-discounts.index') }}">
        <i class="bi bi-box"></i> <span class="align-middle">Service Discounts</span>
        </a>
    </li>
@endif

@endif

<li class="sidebar-header">Market Place Settings</li>

@if(canAccess('media.view'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('medias.index') }}">
        <i class="bi bi-file-image"></i> <span class="align-middle">Media</span>
        </a>
    </li>
@endif


@if(canAccess('age-groups.view'))
    <li class="sidebar-item">
        <a class="sidebar-link"  href="{{ route('age-groups.index') }}">
        <i class="bi bi-calendar2-range-fill"></i></i> <span class="align-middle">Age Groups</span>
        </a>
    </li>
@endif

@if(canAccess('menus.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('menus.index') }}">
            <i class="bi bi-bar-chart-steps"></i><span class="align-middle">menus</span>
        </a>
    </li>
@endif
@if(canAccess('categories.view'))
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('categories.index') }}">
            <i class="bi bi-signpost-2"></i><span class="align-middle">Categories</span>
        </a>
    </li>
@endif

@if(canAccess('modules.provider-settings'))
    <li class="sidebar-header">Provider Settings</li>

    @if(canAccess('locations.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('locations.index') }}">
                <i class="bi bi-geo-alt-fill"></i><span class="align-middle">Locations</span>
            </a>
        </li>
    @endif

    @if(canAccess('providers.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('providers.index') }}">
                <i class="bi bi-truck"></i><span class="align-middle">Providers</span>
            </a>
        </li>
    @endif

    @if(canAccess('provider-inquiries.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('providers-inquiries.index') }}">
                <i class="bi bi-truck"></i><span class="align-middle">Providers Inquiries</span>
            </a>
        </li>
    @endif

    @if(canAccess('stylist-calendar.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('calendar.index') }}">
                <i class="bi bi-calendar-date-fill"></i><span class="align-middle">Provider Calendar</span>
            </a>
        </li>
    @endif
@endif

@if(canAccess('modules.financial-transactions'))
    <li class="sidebar-header">Financial Transactions</li>

    @if(canAccess('transactions.revenue'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('revenues.index') }}">
                <i class="bi bi-bank"></i><span class="align-middle">Revenue</span>
            </a>
        </li>
    @endif
    @if(canAccess('transactions.mpesa-deposit'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('ctob.index') }}">
                <i class="bi bi-cash-coin"></i><span class="align-middle">CtoB</span>
            </a>
        </li>
    @endif
    @if(canAccess('stk-push.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('stk-push.index') }}">
                <i class="bi bi-cash-coin"></i><span class="align-middle">Stk Push</span>
            </a>
        </li>
    @endif
    @if(canAccess('transactions.mpesa-withdraw'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('btoc.index') }}">
                <i class="bi bi-wallet"></i> <span class="align-middle">BtC</span>
            </a>
        </li>
    @endif

    @if(canAccess('wallet-audit.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('wallet-audit.index') }}">
                <i class="bi bi-wallet-fill"></i><span class="align-middle">Wallet Audit</span>
            </a>
        </li>
    @endif
@endif
@if(canAccess('modules.partner-settings'))
    <li class="sidebar-header">Partner Settings</li>

    @if(canAccess('partners.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('partners.index') }}">
                <i class="bi bi-geo-alt-fill"></i><span class="align-middle">Partners</span>
            </a>
        </li>
    @endif
@endif
@if(canAccess('modules.spending'))
    <li class="sidebar-header">Spending</li>

    @if(canAccess('expenses.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('expenses.index') }}">
                <i class="bi bi-credit-card-2-back"></i><span class="align-middle">Expenses</span>
            </a>
        </li>
    @endif
    @if(canAccess('expense-type.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('expense-types.index') }}">
                <i class="bi bi-signpost-split"></i><span class="align-middle">Expense Types</span>
            </a>
        </li>
    @endif
@endif
@if(canAccess('modules.system-setting'))
    <li class="sidebar-header">Campaigns</li>
    @if(canAccess('adverts.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('ads.index') }}">
            <i class="bi bi-badge-ad-fill"></i><span class="align-middle">Adverts</span>
            </a>
        </li>
    @endif

    @if(canAccess('sms-campaigns.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('sms-campaigns') }}">
            <i class="bi bi-funnel-fill"></i> <span class="align-middle">SMS Campaign</span>
            </a>
        </li>
    @endif
    @if(canAccess('email-campaigns.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('email-campaigns') }}">
                <i class="bi bi-envelope-paper-fill"></i><span class="align-middle">Email Campaign</span>
            </a>
        </li>
    @endif
    @if(canAccess('news-letter.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('news-letter.index') }}">
            <i class="bi bi-newspaper"></i><span class="align-middle">News Letter</span>
            </a>
        </li>
    @endif
@endif

@if(canAccess('modules.system-setting'))
    <li class="sidebar-header">System Setting</li>
    <li class="sidebar-item">
        <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout align-middle"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg> <span class="align-middle">Users & Roles</span>
        </a>
        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
            @if(canAccess('users.view'))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> <span class="align-middle">Users</span>
                    </a>
                </li>
            @endif
            @if(canAccess('corporates.view'))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('corporates.index') }}">
                    <i class="bi bi-people"></i> <span class="align-middle">Corporate</span>
                    </a>
                </li>
            @endif
            @if(canAccess('roles.view'))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('roles.index') }}">
                    <i class="bi bi-shield"></i> <span class="align-middle">Roles</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>

    @if(canAccess('channels.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('channels.index') }}">
            <i class="bi bi-funnel-fill"></i> <span class="align-middle">Channels</span>
            </a>
        </li>
    @endif
    @if(canAccess('coupons.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('coupons.index') }}">
            <i class="bi bi-piggy-bank"></i> <span class="align-middle">Coupon</span>
            </a>
        </li>
    @endif

    @if(canAccess('referrals.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('referrals.index') }}">
            <i class="bi bi-share"></i></i> <span class="align-middle">Referrals</span>
            </a>
        </li>
    @endif

    @if(canAccess('stores.view'))
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('franchises.index') }}">
            <i class="bi bi-shop"></i> <span class="align-middle">Stores</span>
            </a>
        </li>
    @endif
@endif