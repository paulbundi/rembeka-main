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
                    <input id="pac-input" name="name" type="text" placeholder="Enter a location" class="form-control"
                      value="{{old('name', isset($address) ? $address->name : '')}}" />
                    <input type="hidden" name="lat_long" id="lat_long" />
                  </div>
                  <div id="map" style="height: 250px;"></div>
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

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    function initMap() {
      // Leaflet Map
      const map = L.map('map').setView([1.2921, 36.8219], 10);

      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);

      let marker = L.marker([1.2921, 36.8219]).addTo(map);

      const input = document.getElementById('pac-input');
      const latLongInput = document.getElementById('lat_long');
      const placeName = document.getElementById('place-name');
      const placeAddress = document.getElementById('place-address');

      let timeout;
      input.addEventListener('input', function () {
        clearTimeout(timeout);
        timeout = setTimeout(searchAddress, 400);
      });

      function searchAddress() {
        const query = input.value.trim();
        if (query.length < 3) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}&countrycodes=ke&addressdetails=1`, {
          headers: { 'User-Agent': 'Rembeka/1.0' }
        })
          .then(response => response.json())
          .then(data => {
            if (data && data[0]) {
              const place = data[0];
              const lat = parseFloat(place.lat);
              const lng = parseFloat(place.lon);

              latLongInput.value = `${lat}, ${lng}`;

              map.setView([lat, lng], 16);
              marker.setLatLng([lat, lng]);

              placeName.textContent = place.display_name.split(',')[0] || place.display_name;
              placeAddress.textContent = place.display_name;
            }
          })
          .catch(err => console.log('Search error:', err));
      }
    }
    window.initMap = initMap;
  </script>

  <!--
  Google Maps - Commented (awaiting API key)
  -->
@endpush