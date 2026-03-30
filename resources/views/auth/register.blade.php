@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="row">
    <div class="col-md-6 offset-md-3 p-4 mt-3 mt-md-0">
            <h2 class="h4 mb-3">No account? Sign up</h2>
            <p class="fs-sm text-muted mb-4">Registration takes less than a minute but gives you full control over your orders.</p>
            @if(session()->has('error'))
                  <div  class="alert alert-danger">
                    <p>{{ session()->get('error') }}</p>
                  </div>
                @endif
            @if ($errors->has('g-recaptcha-response'))
              <span class="help-block">
                <strong class="text-danger">{{ $errors->first('g-recaptcha-response') }}</strong>
              </span>
            @endif
            <form method="POST" action="{{ route('register') }}" id="regForm">
              @csrf
              <dixv class="row gx-4 gy-3">
                <div class="col-sm-6">
                  <label class="form-label" for="reg-fn">First Name</label>
                  <input class="form-control" type="text" required id="reg-fn" name="first_name" value="{{ old('first_name') }}">
                  @error('first_name')
                    <div class="text-danger">Please enter your first name!</div>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-ln">Last Name</label>
                  <input class="form-control" type="text" required id="reg-ln" name="last_name" value="{{ old('last_name') }}">
                  @error('last_name')
                    <div class="text-danger">Please enter your last name!</div>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-email">E-mail Address</label>
                  <input class="form-control" type="email" required id="reg-email" name="email" value="{{ old('email') }}">
                  @error('email')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-phone">Phone Number</label>
                  <input class="form-control" type="text" required id="reg-phone" name="phone" value="{{ old('phone') }}">
                  @error('phone')
                    <div class="text-danger">{{ $message}}</div>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-password">Password</label>
                  <input class="form-control" type="password" required id="reg-password" name="password">
                  @error('password')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-password-confirm">Confirm Password</label>
                  <input class="form-control" type="password" required id="reg-password-confirm" name="password_confirmation">
                  @error('password_confirmation')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <input type="checkbox" name="terms" required="true">
                    I have read and agreed to the <a target="_blank" href="/terms-and-condition">Term of Service.</a>
                    @error('terms')
                      <div class="text-danger">You must accept our terms of service to proceed.</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="privacy" required="true">
                    I have read and agreed to the Data Protection and Privacy Polices 
                    <a target="_blank" href="/data-privacy">Data Privacy</a>
                    @error('privacy')
                      <div class="text-danger">You must accept our Data Protection and Privacy Polices.</div>
                    @enderror
                  </div>
                </div>

                <div class="col-12 text-end mb-sm-100">
                  <div class="col-12 d-grid">
                    {!! NoCaptcha::displaySubmit('regForm', 'Sign Up', ['data-theme' => 'dark', 'class' => 'btn btn-sm btn-primary text-white','id' => 'register']) !!}
                  </div>
                  
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 me-4" href="{{ route('login') }}">
                      {{ __('Already registered?') }}
                    </a>
                </div>
              </div> 
            </form>
          </div>
    </div>
</main>
@endsection