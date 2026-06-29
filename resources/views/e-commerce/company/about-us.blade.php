@extends('layouts.e-commerce')

@section('seo')
    @php($pageTitle = 'About us') @endphp
    <title>Rembeka - {{ $pageTitle }}</title>
@endsection

@section('content')
    <main style="padding-top: 5rem;">
        <div class="container py-5">
            <div class="bg-light rounded-3 p-4 p-md-5 mb-5">
                <h1 class="h3 mb-4" style="color:#1e293b; font-weight:800;">About Rembeka</h1>
                <p class="lead mb-4" style="color:#1e293b;">Kenya's Beauty Platform</p>
                <p class="text-muted fs-lg mb-4">Rembeka Online Limited is a Kenyan e-commerce platform that makes beauty simple. We connect customers with authentic beauty products, trusted professionals, and premium beauty services — all in one place.</p>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="bg-white rounded-3 p-4 h-100 shadow-sm">
                            <h3 class="h5 fw-bold mb-3" style="color:#c12c5d;">Our Mission</h3>
                            <p class="text-muted mb-0">To provide convenient access to genuine beauty products and verified beauty professionals across Kenya.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white rounded-3 p-4 h-100 shadow-sm">
                            <h3 class="h5 fw-bold mb-3" style="color:#c12c5d;">Our Vision</h3>
                            <p class="text-muted mb-0">To be the most trusted beauty platform in Africa, empowering both customers and industry professionals.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white rounded-3 p-4 h-100 shadow-sm">
                            <h3 class="h5 fw-bold mb-3" style="color:#c12c5d;">Our Values</h3>
                            <p class="text-muted mb-0">Authenticity, trust, convenience, and empowerment guide everything we do at Rembeka.</p>
                        </div>
                    </div>
                </div>

                <h2 class="h4 mb-3" style="color:#1e293b;">What We Offer</h2>
                <ul class="list-unstyled text-muted mb-0">
                    <li class="mb-2">• Curated authentic beauty products from top brands</li>
                    <li class="mb-2">• Verified beauty professionals and stylists</li>
                    <li class="mb-2">• Seamless booking and scheduling of beauty services</li>
                    <li class="mb-2">• Secure payments and reliable delivery</li>
                    <li class="mb-2">• Community-driven reviews and recommendations</li>
                </ul>
            </div>
        </div>
    </main>
@endsection
