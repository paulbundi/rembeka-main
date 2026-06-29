@extends('layouts.e-commerce')

@section('seo')
    @php($pageTitle = 'Contacts') @endphp
    <title>Rembeka - {{ $pageTitle }}</title>
@endsection

@section('content')
    <main style="padding-top: 5rem;">
        <div class="container py-5">
            <div class="bg-light rounded-3 p-4 p-md-5 mb-5">
                <h1 class="h3 mb-4" style="color:#1e293b; font-weight:800;">Contact Us</h1>
                <p class="text-muted fs-lg mb-4">Have questions, feedback, or need support? Reach out to us through any of the channels below.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="bg-white rounded-3 p-4 shadow-sm h-100">
                        <h2 class="h5 fw-bold mb-4" style="color:#1e293b;">Office Address</h2>
                        <p class="text-muted mb-1"><i class="ci-location me-2" style="color:#c12c5d;"></i> Mpaka Rd, Nairobi, Kenya</p>
                        <p class="text-muted mb-4"><strong>Rembeka Online Limited</strong></p>

                        <h2 class="h5 fw-bold mb-3" style="color:#1e293b;">Get in Touch</h2>
                        <p class="text-muted mb-2"><i class="ci-phone me-2" style="color:#c12c5d;"></i> <a href="https://wa.me/{{ config('services.whatsapp.rembeka_whatsapp_no') }}" target="_blank">Chat on WhatsApp</a></p>
                        <p class="text-muted mb-4"><i class="ci-mail me-2" style="color:#c12c5d;"></i> <a href="mailto:info@rembekaonline.com">info@rembekaonline.com</a></p>

                        <h2 class="h5 fw-bold mb-3" style="color:#1e293b;">Follow Us</h2>
                        <div class="d-flex flex-wrap gap-3">
                            <a class="btn btn-outline-dark btn-sm" href="https://www.facebook.com/RembekaOnline" target="_blank"><i class="ci-facebook me-1"></i> Facebook</a>
                            <a class="btn btn-outline-dark btn-sm" href="https://www.instagram.com/rembekaonline/" target="_blank"><i class="ci-instagram me-1"></i> Instagram</a>
                            <a class="btn btn-outline-dark btn-sm" href="https://www.youtube.com/@rembekaonline4295" target="_blank"><i class="ci-youtube me-1"></i> YouTube</a>
                            <a class="btn btn-outline-dark btn-sm" href="https://www.tiktok.com/@rembekaonline?_r=1&_t=ZS-95UxwGwkb5D" target="_blank"><i class="ci-tiktok me-1"></i> TikTok</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white rounded-3 p-4 shadow-sm h-100">
                        <h2 class="h5 fw-bold mb-4" style="color:#1e293b;">Business Hours</h2>
                        <ul class="list-unstyled text-muted mb-4">
                            <li class="d-flex justify-content-between py-2 border-bottom"><span>Monday - Friday</span> <span>8:00 AM - 6:00 PM</span></li>
                            <li class="d-flex justify-content-between py-2 border-bottom"><span>Saturday</span> <span>9:00 AM - 4:00 PM</span></li>
                            <li class="d-flex justify-content-between py-2"><span>Sunday & Public Holidays</span> <span>Closed</span></li>
                        </ul>

                        <h2 class="h5 fw-bold mb-3" style="color:#1e293b;">Quick Links</h2>
                        <ul class="list-unstyled text-muted mb-0">
                            <li class="mb-2"><a href="{{ url('/terms-and-condition') }}" class="text-decoration-none" style="color:#c12c5d;">Terms & Conditions</a></li>
                            <li class="mb-2"><a href="{{ url('/data-privacy') }}" class="text-decoration-none" style="color:#c12c5d;">Data Privacy Policy</a></li>
                            <li class="mb-2"><a href="{{ url('/company/about-us') }}" class="text-decoration-none" style="color:#c12c5d;">About Us</a></li>
                            <li class="mb-2"><a href="{{ url('/company/careers') }}" class="text-decoration-none" style="color:#c12c5d;">Careers</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
