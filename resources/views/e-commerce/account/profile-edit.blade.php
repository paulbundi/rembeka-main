@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8">
            <div class="row mb-2">
              <div class="col-12 col-sm-6">
                  <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center  align-items-center">
                      @if(auth()->user()->account_type == App\Models\User::TYPE_USER)
                        <h3>Available Points</h3>
                      @else
                        <h3>Wallet Amount</h3>
                      @endif
                      <h4>Ksh {{  number_format(auth()->user()->wallet, 2) }}</h4>
                    </div>
                  </div>
              </div>

              <div class="col-12 col-sm-6 mt-2">
                @if(auth()->user()->account_type == App\Models\User::TYPE_USER || auth()->user()->account_type == App\Models\User::TYPE_ADMIN )
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Buy Points</h4>
                      <form method="POST" action="{{ route('buy.points') }}" onSubmit="handleSumbmitForm('buypoints-loading')">
                        @csrf
                        <div class="form-group">
                          <label>Buy points for future service</label><br/>
                          <small class="text-info">Each point is equivalent to one shillings.</small>
                          @if(session()->has('notice'))
                           <div class="alert bg-success">{{session()->get('notice')}}</div>
                           <a href="{{route('profile.index')}}" class="btn btn-primary">Confirm Payment</a>
                          @else
                          <input type="number" class="form-control" placeholder="Amount" name="amount" required="true"/>
                          @error('amount')
                            <span class="text-danger">{{$message}}</span><br/>
                          @enderror
                         
                          <button class="btn btn-success mt-2 d-flex align-items-center w-100 buypoints-loading" type="submit">
                            <div class="spinner-grow d-none" id="buypoints-loading" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <b>Buy Points from Mpesa</b>
                          </button>
                          @endif
                        </div>
                      </form>
                    </div>
                  </div>
                @endif
                @if(auth()->user()->account_type != App\Models\User::TYPE_USER  && auth()->user()->wallet > 10)
                  <div class="card mt-2">
                    <div class="card-body">
                      <h4 class="card-title"> Withdraw to Mpesa</h4>
                      <form method="POST" action="{{ route('wallet.withdraw') }}" onSubmit="handleSumbmitForm('withdraw-loading')">
                        @csrf
                        <div class="form-group ">
                          <label>Amount</label>
                          <input type="number" class="form-control" placeholder="amount" name="amount" required="true"/>
                          @error('amount')
                                <span class="text-danger">{{$message}}</span><br/>
                          @enderror
                          <button class="btn btn-success mt-2 d-flex align-items-center withdraw-loading" type="submit">
                                <div class="spinner-grow d-none" id="withdraw-loading" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                          Withdraw
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <div class="card">
              <div class="card-body">
              <!-- Profile form-->
              <h5 class="card-title">My Profile</h5>
                <form method="POST" action="{{ route('profile.update', auth()->id()) }}">
                  @csrf
                  @method('PUT')
                  <div class="row gx-4 gy-3">
                    <div class="col-sm-6">
                      <label class="form-label" for="account-fn">First Name</label>
                      <input class="form-control" type="text" id="account-fn" name="first_name" value="{{auth()->user()->first_name}}">
                      @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="account-ln">Last Name</label>
                      <input class="form-control" type="text" name="last_name" id="account-ln" value="{{auth()->user()->last_name}}">
                      @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="account-email">Email Address</label>
                      <input class="form-control" type="email" name="email" id="account-email" value="{{auth()->user()->email}}" readonly>
                      @error('email')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="account-phone">Phone Number</label>
                      <input class="form-control" type="text" name="phone" id="account-phone" value="{{auth()->user()->phone}}" required {{ auth()->user()->account_type == \App\Models\User::TYPE_PROVIDER ? 'readonly': ''}}>
                      @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-12">
                      <hr class="mt-2 mb-3">
                      <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="subscribe_me" checked>
                          <label class="form-check-label" for="subscribe_me">Subscribe me to Newsletter</label>
                        </div>
                        <button class="btn btn-primary mt-3 mt-sm-0" type="submit">Update profile</button>
                      </div>
                    </div>

                  </div>
                </form>
              </div>
            </div>

            <div class="card mt-2">
              <div class="card-body">
                <h4 class="card-title">Update Password</h4>
                <form method="post" action="{{ route('user-password.update') }}">
                  @csrf
                  <div class="col-12 col-sm-6">
                      <label class="form-label" for="account-pass">Current Password</label>
                      <div class="password-toggle">
                        <input class="form-control" type="password" name="old_password" id="account-pass">
                        <label class="password-toggle-btn" aria-label="Show/hide password">
                          <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                        </label>
                        @error('old_password')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>

                <div class="col-12 col-sm-6">
                      <label class="form-label" for="account-pass">New Password</label>
                      <div class="password-toggle">
                        <input class="form-control" type="password" name="password" id="account-pass">
                        <label class="password-toggle-btn" aria-label="Show/hide password">
                          <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                        </label>
                        @error('password')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12 col-sm-6">
                      <label class="form-label" for="account-confirm-pass">Confirm Password</label>
                      <div class="password-toggle">
                        <input class="form-control" type="password" id="account-confirm-pass" name="password_confirmation">
                        <label class="password-toggle-btn" aria-label="Show/hide password">
                          <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                        </label>
                      </div>

                      <div class="form-group mt-2">
                        <button class="btn btn-primary mt-3 mt-sm-0" type="submit">Update Password</button>
                      </div>
                    </div>

                </form>
              </div>
            </div>
          </section>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
function handleSumbmitForm(targetButton) {
  let element = document.getElementById(`${targetButton}`);
  if(element){
    element.classList.remove("d-none");
    element.parentElement.disabled = 'true'
  }
}
</script>
@endpush
