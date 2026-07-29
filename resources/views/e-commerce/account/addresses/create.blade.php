@extends('layouts.e-commerce')
@section('content')
  <main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
      <div class="row">
        @include('layouts.account-partial')

        <section class="col-lg-8">
          @if(isset($address))
            <form method="POST" action="{{ route('addresses.update', $address->id) }}">
              @method('PUT')
          @else
              <form method="POST" action="{{ route('addresses.store')}}">
            @endif
              @csrf
              <div class="row gx-4 gy-3">

                <div class="col-12">
                  <div id="pac-container">
                    <label>Enter Your Location</label>
                    <input id="pac-input" name="name" type="text" placeholder="Enter a location in Kenya"
                      class="form-control"
                      value="{{old('name', isset($address) ? $address->name : '')}}" />
                    <input type="hidden" name="lat_long" id="lat_long" />
                  </div>
                  <div id="map" style="height: 250px; width: 100%; border-radius: 0.375rem; border: 1px solid #dee2e6; overflow: hidden;"></div>
                  <div id="infowindow-content">
                    <span id="place-name" class="title"></span><br />
                    <span id="place-address"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-ln">Appartment</label>
                  <input class="form-control" type="text" name="appartment" id="account-ln"
                    value="{{old('appartment', isset($address) ? $address->appartment : '')}}">
                  @error('appartment')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-floor">floor</label>
                  <input class="form-control" type="text" name="floor" id="account-floor"
                    value="{{old('floor', isset($address) ? $address->floor : '')}}">
                  @error('floor')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-room">Room</label>
                  <input class="form-control" type="text" name="room" id="account-room"
                    value="{{old('room', isset($address) ? $address->room : '')}}">
                  @error('room')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-12">
                  <hr class="mt-2 mb-3">
                  <button class="btn btn-primary mt-3 mt-sm-0" type="submit">@if(isset($address)) update @else Create
                  @endif address</button>
                </div>
              </div>
      </div>
      </form>

      </section>

    </div>
    </div>
  </main>
@endsection

@push('css')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    function initMap() {
      const defaultLat = -1.2921;
      const defaultLng = 36.8219;

      const map = L.map('map', {
        center: [defaultLat, defaultLng],
        zoom: 13,
        scrollWheelZoom: false,
        zoomSnap: 0.5,
        zoomDelta: 0.5,
        doubleClickZoom: false,
        inertia: true,
        inertiaDeceleration: 4000,
      }).setView([defaultLat, defaultLng], 13);

      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);

      let marker = L.marker([defaultLat, defaultLng]).addTo(map);

      const input = document.getElementById('pac-input');
      const latLongInput = document.getElementById('lat_long');
      const placeName = document.getElementById('place-name');
      const placeAddress = document.getElementById('place-address');

      let timeout;
      if (input) {
        input.addEventListener('input', function () {
          clearTimeout(timeout);
          timeout = setTimeout(searchAddress, 400);
        });
      }

      function searchAddress() {
        if (!input) return;
        const query = input.value.trim();
        if (query.length < 3) return;

        fetch('{{ route('delivery.geocode') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json',
          },
          body: JSON.stringify({ address: query }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data && data.latitude) {
              const lat = parseFloat(data.latitude);
              const lng = parseFloat(data.longitude);

              latLongInput.value = lat + ', ' + lng;

              map.setView([lat, lng], 16);
              marker.setLatLng([lat, lng]);

              placeName.textContent = data.displayName ? data.displayName.split(',')[0] : data.displayName;
              placeAddress.textContent = data.displayName;
            }
          })
          .catch(err => console.log('Search error:', err));
      }

      map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 16);

        fetch('{{ route('delivery.reverse-geocode') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json',
          },
          body: JSON.stringify({ latitude: lat, longitude: lng }),
        })
          .then((response) => response.json())
          .then((data) => {
            latLongInput.value = lat + ', ' + lng;
            placeName.textContent = data.displayName ? data.displayName.split(',')[0] : data.displayName;
            placeAddress.textContent = data.displayName || lat + ', ' + lng;
          })
          .catch(() => {
            latLongInput.value = lat + ', ' + lng;
            placeName.textContent = 'Selected location';
            placeAddress.textContent = lat + ', ' + lng;
          });
      });
    }
    window.initMap = initMap;

    document.addEventListener('DOMContentLoaded', function () {
      initMap();
    });
  </script>

  <!--
  Google Maps - Commented (awaiting API key)
  -->
@endpush