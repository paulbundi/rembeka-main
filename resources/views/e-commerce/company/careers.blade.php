@extends('layouts.e-commerce')

@section('seo')
    @php($pageTitle = 'Careers at rembeka') @endphp
    <title>Rembeka - {{ $pageTitle }}</title>
@endsection

@section('content')
    <main style="padding-top: 5rem;">
        <div class="container py-5">
            <div class="bg-light rounded-3 p-4 p-md-5 mb-5">
                <h1 class="h3 mb-3" style="color:#1e293b; font-weight:800;">Careers at Rembeka</h1>
                <div class="alert alert-info mb-0" role="alert">
                    <h4 class="alert-heading fw-bold">No openings currently</h4>
                    <p class="mb-0">We are not actively hiring at the moment, but we are always interested in hearing from talented individuals who want to join our mission of making beauty simple in Kenya.</p>
                </div>
            </div>

            <div class="bg-white rounded-3 p-4 p-md-5 shadow-sm">
                <h2 class="h4 mb-4" style="color:#1e293b;">Submit your details</h2>
                <p class="text-muted mb-4">Fill out the form below and we will keep your information on file for future opportunities.</p>
                <form method="POST" action="{{ url('/company/careers') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="career-name">Full Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="career-name" placeholder="Enter your full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="career-email">Email Address <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" id="career-email" placeholder="Enter your email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="career-phone">Phone Number</label>
                            <input class="form-control" type="tel" name="phone" id="career-phone" placeholder="+254 7XX XXX XXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="career-position">Position of Interest</label>
                            <input class="form-control" type="text" name="position" id="career-position" placeholder="e.g. Product Designer, Software Engineer">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="career-cover">Cover Letter / Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="cover_letter" id="career-cover" rows="5" placeholder="Tell us about yourself and why you want to work at Rembeka..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary px-4" type="submit">Submit Application</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
