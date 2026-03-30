<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle d-flex">
		<i class="hamburger align-self-center"></i>
	</a>

	<form class="d-none d-sm-inline-block">
		<div class="input-group input-group-navbar">
			<input type="text" class="form-control" placeholder="Search…" aria-label="Search">
			<button class="btn" type="button">
				<i class="align-middle" data-feather="search"></i>
			</button>
		</div>
	</form>

	<div class="navbar-collapse collapse">
		<div class="col-4">
			<h4 class="text-center">Paybill No: <b style="color:#222e3c;">4087941</b></h4>
		</div>
		<ul class="navbar-nav navbar-align">
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="bell"></i>
						<span class="indicator">{{ auth()->user()->unreadNotifications->count() }}</span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">
					{{ auth()->user()->unreadNotifications->count() }} New Notifications
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="bi bi-bell"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Update completed</div>
									<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
									<div class="text-muted small mt-1">30m ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="{{ route('notifications') }}" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
					<i class="align-middle" data-feather="settings"></i>
				</a>

				<a class="nav-link dropdown-toggle d-flex" href="#" data-bs-toggle="dropdown">
					<div class="me-2">
						<user-icon :user="{{ auth()->user() }}" />
					</div>
					<div>
						<span class="text-dark">{{ auth()->user()->first_name }}</span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="{{ route('profile.index')}}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>

					@if(isImpersonating())
					<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('users-exit-impersonate', auth()->id() )}}">
							<i class="align-middle me-1" data-feather="pie-chart"></i>
							Exit Impersonation
						</a>
					@endif
					<div class="dropdown-divider"></div>
					<form  action="{{ route('logout') }}" method="POST" width="100%">
						{{ csrf_field() }}
						<button class="dropdown-item btn btn-block d-flex align-items-start pl-0" type="submit">
							<i class="fa fa-power-off ml-0" style="margin-top: 3px;"></i>
							<span class="ml-1">Logout</span>
						</button>
					</form>
				</div>
			</li>
		</ul>
	</div>
</nav>