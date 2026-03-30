@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 mt-2">
            <div class="card border-0 shadow">
              <div class="card-body">

                <h2 class="h4 mb-1">Sign in</h2>
                @include('e-commerce.auth.social-login')

                @if(session()->has('error'))
                  <div  class="alert alert-danger">
                    <p>{{ session()->get('error') }}</p>
                  </div>
                @endif
                <hr>
                <h3 class="fs-base pt-4 pb-2">Or using form below</h3>

                @error('email')
                  <b class="text-danger mb-2">{{ $message }}</b>
                @enderror
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="input-group mb-3"><i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" name="email" type="email" placeholder="Email" required>
                  </div>
                  <div class="input-group mb-3"><i class="ci-locked position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                    <div class="password-toggle w-100">
                      <input class="form-control" type="password" name="password" placeholder="Password" required>
                      <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                      </label>
                    </div>
                  </div>
                  <div class="d-flex flex-wrap justify-content-between">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" checked id="remember_me" name="remember">
                      <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                  </div>
                  <hr class="mt-4">
                  <div class="d-flex justify-content-between pt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('Don`t have an account?') }} Click here to register
                    </a>
                    <button class="btn btn-primary" type="submit"><i class="ci-sign-in me-2 ms-n21"></i>Sign In</button>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</main>
@endsection