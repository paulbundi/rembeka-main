@extends('layouts.e-commerce')

@section('seo')
    <title>Rembeka - Store locator</title>
@endsection

@section('content')
    <main style="padding-top: 5rem;">
        <div class="container py-5">
            <div class="bg-white rounded-3 p-4 p-md-5 shadow-sm mb-4">
                <h1 class="h3 mb-2" style="color:#1e293b; font-weight:800;">Store Locator</h1>
                <p class="text-muted mb-4">Find us at our office along Mpaka Road, Nairobi.</p>
                <p class="mb-0"><i class="ci-location me-2" style="color:#c12c5d;"></i> <strong>Address:</strong> Mpaka Rd,
                    Nairobi, Kenya</p>
            </div>
            <div class="bg-light rounded-3 p-2 p-md-3">
                <div id="map"
                    style="height: 450px; width: 100%; border-radius: 0.375rem; border: 1px solid #dee2e6; overflow: hidden;">
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        function initMap() {
            // "Store locator" style: reduce interaction to avoid the map feeling jittery/shaky.
            const map = L.map('map', {
                scrollWheelZoom: false,
                dragging: true,
                zoomControl: true,
                doubleClickZoom: false,
                touchZoom: true,
                zoomSnap: 0.5,
                zoomDelta: 0.5,
                wheelPxPerZoomLevel: 120,
                inertia: true,
                inertiaDeceleration: 4000
            }).setView([-1.2630, 36.8080], 15);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([-1.2630, 36.8080]).addTo(map)
                .bindPopup('<strong>Rembeka Online Limited</strong><br>Mpaka Rd, Nairobi, Kenya')
                .openPopup();
        }
        window.initMap = initMap;
        document.addEventListener('DOMContentLoaded', function () {
            initMap();
        });
    </script>
@endpush