<div class="row gx-4 gy-3 mt-2">
  @error('name')
    <div class="alert bg-danger">
      <span class="text-white">The delivery location is required.</span>
    </div>
  @enderror

  @error('address_id')
    <div class="alert bg-danger">
      <span class="text-white">The delivery location is required.</span>
    </div>
  @enderror
  <div class="col-12">
    <div id="pac-container">
      <label class="fw-bolder">Add a new Address</label>
      <input id="pac-input" name="name" type="text" placeholder="Enter a location" class="form-control" />
      <input type="hidden" name="lat_long" id="lat_long" />
    </div>
    <div class="position-relative mt-2" style="height: 250px;">
      <div id="map" class="w-100 h-100"></div>
    </div>
    <div id="infowindow-content" class="mt-2">
      <span id="place-name" class="title fw-bold"></span><br />
      <span id="place-address" class="text-muted small"></span>
    </div>

  </div>
  <div class="col-sm-6">
    <label class="form-label" for="account-ln">Apartment/Building/Estate<small>(required)</small></label>
    <input class="form-control" type="text" name="apartment" id="account-ln" value="{{old('apartment')}}">
    @error('apartment')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>
  <div class="col-sm-6">
    <label class="form-label" for="account-floor">House No/Floor<small>(Optional)</small></label>
    <input class="form-control" type="text" name="floor" id="account-floor" value="{{old('floor')}}">
    @error('floor')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>
  <div class="col-sm-6">
    <label class="form-label" for="account-room">Room<small>(Optional)</small></label>
    <input class="form-control" type="text" name="room" id="account-room" value="{{old('room')}}">
    @error('room')
      <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>

</div>

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
  <!-- Leaflet Map (Active - Free) -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    function initMap() {
      // Leaflet implementation
      const map = L.map('map').setView([1.2921, 36.8219], 10); // Nairobi default

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

              latLongInput.value = `${lat},${lng}`;

              map.setView([lat, lng], 16);
              marker.setLatLng([lat, lng]);

              placeName.textContent = place.display_name.split(',')[0] || place.display_name;
              placeAddress.textContent = place.display_name;

              // Invalidate map size to fix rendering issues
              setTimeout(() => map.invalidateSize(), 100);
            }
          })
          .catch(err => console.log('Search error:', err));
      }
    }
    window.initMap = initMap;

    // Initialize map on page load
    document.addEventListener('DOMContentLoaded', function () {
      initMap();
    });
  </script>

  <!--
  GOOGLE MAPS - Ready (add GOOGLE_MAPS_API_KEY to .env)
  -->
  @endpush