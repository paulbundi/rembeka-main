@extends('layouts.e-commerce')

@section('seo')
    @php($pageTitle = 'Contacts') @endphp
    <title>Rembeka - {{ $pageTitle }}</title>
@endsection

@section('content')
    <main style="padding-top: 5rem;">
        <div class="container">
            <div class="bg-light rounded-3 p-4 my-4">
                <h1 class="h3" style="color:#1e293b; font-weight:800;">Contacts (Placeholder)</h1>
                <p class="text-muted mb-0">We’ll add support phone/email and address later.</p>
            </div>
        </div>
    </main>
@endsection