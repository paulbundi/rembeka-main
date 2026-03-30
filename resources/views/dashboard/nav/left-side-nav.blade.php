<nav id="sidebar" class="sidebar">
	<div class="sidebar-content js-simplebar">
			<h4 class="text-white fw-bolder ms-3 my-4">Rembeka</h4>

		<ul class="sidebar-nav mt-2">
			<li class="sidebar-item">
				<!-- Example split danger button -->
				<div class="btn-group">
					<a class="sidebar-link w-100" href="{{ route('dashboard') }}" >
						<i class="bi bi-window-dash"></i>
						<span class="align-middle">Dashboard</span>
					</a>
					<button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
						<span class="visually-hidden">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item"href="{{ route('dashboard.service') }}">Service</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item"href="{{ route('dashboard.product') }}">Product</a></li>
					</ul>
				</div>

			</li>
			@if(auth()->user() && auth()->user()->account_type == App\Models\User::TYPE_ADMIN )
				@include('dashboard.nav.admin-menu')
			@endif
			@if(auth()->user() && auth()->user()->account_type == App\Models\User::TYPE_CORPORATE )
				@include('dashboard.nav.corporate-menu')
			@endif
		</ul>
	</div>
</nav>