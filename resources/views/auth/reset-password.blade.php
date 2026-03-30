@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 mt-2">
            <div class="card border-0 shadow">
              <div class="card-body">
                <h2 class="h4 mb-1">Reset Password</h2>
                <form method="POST" action="{{ route('password.update') }}" class="mt-3">
                    @csrf
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                  <div class="input-group mb-3"><i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" name="email" type="email" value="{{old('email', $request->email)}}" placeholder="Email" required>
                  </div>
                  <div class="input-group mb-3">
                      <i class="ci-locked position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                        <div class="password-toggle w-100">
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                  </div>
                  <div class="input-group mb-3">
                      <i class="ci-locked position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                        <div class="password-toggle w-100">
                            <input class="form-control" type="password" name="password_confirmation" placeholder="Password" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                  </div>

                  <hr class="mt-4">
                  <div class="d-flex justify-content-between pt-4">
                    <button class="btn btn-primary" type="submit"><i class="ci-sign-in me-2 ms-n21"></i>{{ __('Reset Password') }}</button>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</main>
@endsection