@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="row">
    <div class="col-md-6 offset-md-3 pt-4 mt-3 mt-md-0">
            <h2 class="h4 mb-3">Password Reset</h2>
            <p class="fs-sm text-muted mb-4">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>
            <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />


              <div class="row gx-4 gy-3">
                <div class="col">
                  <label class="form-label" for="reg-email">E-mail Address</label>
                  <input class="form-control" type="email" required id="reg-email" name="email" value="{{ old('email') }}">
                  @error('email')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
   
                <div class="col-12">
                  <button class="btn btn-primary" type="submit"><i class="ci-user me-2 ms-n1"></i>
                    {{ __('Send reset password link') }}
                    </button>
                </div>
              </div>
            </form>
          </div>
    </div>
</main>
@endsection