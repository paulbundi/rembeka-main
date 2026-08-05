@extends('layouts.e-commerce')
@section('content')
<main style="padding-top: 6rem;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h3 mb-1 text-uppercase fw-bold" style="color: #1e293b;">Inquiries</h2>
                        <p class="text-muted mb-4">Fill in the details below and our team will get back to you.</p>

                        @if(session()->has('success'))
                            <div class="alert alert-success">{{ session()->get('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('stylist-inquiries') }}" id="providerInquiryForm">
                            @csrf
                            <div class="row g-3 gx-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="first_name">First Name</label>
                                    <input class="form-control" type="text" required id="first_name" name="first_name" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input class="form-control" type="text" required id="last_name" name="last_name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email Address</label>
                                    <input class="form-control" type="email" required id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone Number</label>
                                    <input class="form-control" type="text" required id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="address">Address / Location</label>
                                    <input class="form-control" type="text" required id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="professional_qualifications">Professional Qualifications</label>
                                    <textarea class="form-control" required id="professional_qualifications" name="professional_qualifications" rows="3">{{ old('professional_qualifications') }}</textarea>
                                    @error('professional_qualifications')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="works_experience">Work Experience</label>
                                    <textarea class="form-control" required id="works_experience" name="works_experience" rows="3">{{ old('works_experience') }}</textarea>
                                    @error('works_experience')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-shadow">Submit Inquiry</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.e-commerce-footer')
</main>
@endsection
