@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="row">
        <div class="col-9 offset-1 col-lg-8 offset-lg-3 mt-4">
         
            <form method="POST" action="{{ route('verify.otp') }}">
                @csrf
                <div class="row">
                <div class="col-sm-8">
                    <div class="mb-2">
                        <label class="form-label" for="otp">Very Phone Number</label>
                        <input class="form-control" name="otp" type="text" id="otp" required>
                    </div>
                    @if(session()->has('error'))
                        <span class="text-danger">{{ session()->get('error') }}</span>
                    @endif

                    @if(session()->has('otp-to-mail'))
                        <p class="text-success">Please check your email for the verification code if you dont receive it on your mobile phone.</p>
                    @endif
                    <p>Did not recieve an OTP? <a href="{{ route('otp.resend')}}" class="ms-2"><b>Resend</b></a></p>
                </b>
                </div>
                <div class="d-none d-lg-flex pt-4 mt-3">
                    <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" type="submit"><span class="d-none d-sm-inline">Verify Otp</span><span class="d-inline d-sm-none">Next</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection