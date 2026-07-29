<div class="row gx-4 gy-3 mt-2">
  <div class="col-12">
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
  </div>

  <div class="col-12">
    <div class="delivery-option-toggle mb-3">
      <label class="fw-bolder d-block mb-2">Delivery Method</label>
      <div class="btn-group w-100" role="group">
        <input type="radio" class="btn-check" name="delivery_method" id="delivery_pickup" value="PICKUP" checked>
        <label class="btn btn-outline-primary" for="delivery_pickup">Store Pickup (Free)</label>

        <input type="radio" class="btn-check" name="delivery_method" id="delivery_delivery" value="DELIVERY">
        <label class="btn btn-outline-primary" for="delivery_delivery">Home Delivery</label>
      </div>
    </div>
  </div>

  <div class="col-12 d-none" id="delivery-address-section">
    <div class="mb-3">
      <label class="fw-bolder">Delivery Address</label>
      <input id="pac-input" name="name" type="text" placeholder="Search a location in Kenya" class="form-control" />
      <input type="hidden" name="latitude" id="latitude" value="-1.2921" />
      <input type="hidden" name="longitude" id="longitude" value="36.8219" />
      <input type="hidden" name="delivery_fee" id="delivery_fee" value="0" />
      <input type="hidden" name="delivery_method" id="delivery_method_hidden" value="PICKUP" />
    </div>
    <div class="mb-3" style="height: 250px; clear: both; overflow: hidden;">
      <div id="map" style="height: 250px; width: 100%; border-radius: 0.375rem; border: 1px solid #dee2e6;"></div>
    </div>
    <div id="delivery-fee-display" class="mb-3 d-none">
      <div class="alert alert-info py-2">
        <div class="d-flex justify-content-between">
          <span>Distance:</span>
          <span class="fw-semibold" id="delivery-distance">--</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Delivery fee:</span>
          <span class="fw-semibold" id="delivery-fee-text">KES 0</span>
        </div>
      </div>
    </div>
    <div id="geocoding-status" class="mb-2 d-none">
      <p class="text-xs text-muted mb-0">Finding location...</p>
    </div>
  </div>

  <div class="col-sm-6">
    <label class="form-label" for="account-ln">Apartment/Building/Estate<small>(required)</small></label>
    <input class="form-control" type="text" name="appartment" id="account-ln" value="{{old('appartment')}}">
    @error('appartment')
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

@push('css')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <style>
    #map {
      min-height: 250px;
      background: #f8f9fa;
    }
    .leaflet-container {
      z-index: 0;
    }
    .delivery-address-section.d-none {
      display: none !important;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    function initMap() {
      const mapContainer = document.getElementById('map');
      if (!mapContainer) return;

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
      });

      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);

      let marker = L.marker([defaultLat, defaultLng]).addTo(map);

      const input = document.getElementById('pac-input');
      const latitudeInput = document.getElementById('latitude');
      const longitudeInput = document.getElementById('longitude');
      const deliveryFeeInput = document.getElementById('delivery_fee');
      const deliveryMethodHidden = document.getElementById('delivery_method_hidden');
      const deliveryAddressSection = document.getElementById('delivery-address-section');
      const deliveryFeeDisplay = document.getElementById('delivery-fee-display');
      const deliveryDistanceText = document.getElementById('delivery-distance');
      const deliveryFeeText = document.getElementById('delivery-fee-text');
      const geocodingStatus = document.getElementById('geocoding-status');
      const pickupRadio = document.getElementById('delivery_pickup');
      const deliveryRadio = document.getElementById('delivery_delivery');

      setTimeout(() => map.invalidateSize(), 200);

      function setLoading(loading) {
        if (geocodingStatus) {
          geocodingStatus.classList.toggle('d-none', !loading);
        }
      }

      function updateFee(lat, lng) {
        const method = deliveryMethodHidden ? deliveryMethodHidden.value : 'PICKUP';
        if (method !== 'DELIVERY') {
          if (deliveryFeeDisplay) deliveryFeeDisplay.classList.add('d-none');
          if (deliveryFeeInput) deliveryFeeInput.value = '0';
          return;
        }

        setLoading(true);
        fetch('{{ route('delivery.calculate') }}', {
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
            if (deliveryFeeDisplay) deliveryFeeDisplay.classList.remove('d-none');
            if (deliveryFeeInput) deliveryFeeInput.value = data.fee ?? 0;
            if (deliveryDistanceText) deliveryDistanceText.textContent = data.distanceKm + ' km';
            if (deliveryFeeText) {
              deliveryFeeText.textContent = data.fee === 0 ? 'Free' : 'KES ' + Number(data.fee).toLocaleString();
            }
          })
          .catch(() => {
            if (deliveryFeeDisplay) deliveryFeeDisplay.classList.remove('d-none');
            if (deliveryFeeInput) deliveryFeeInput.value = '0';
            if (deliveryDistanceText) deliveryDistanceText.textContent = '--';
            if (deliveryFeeText) deliveryFeeText.textContent = 'KES 0';
          })
          .finally(() => {
            setLoading(false);
          });
      }

      function setLocation(lat, lng, address) {
        latitudeInput.value = lat;
        longitudeInput.value = lng;
        map.setView([lat, lng], 16);
        marker.setLatLng([lat, lng]);

        if (address && document.getElementById('place-name')) {
          document.getElementById('place-name').textContent = address.split(',')[0] || address;
        }
        if (address && document.getElementById('place-address')) {
          document.getElementById('place-address').textContent = address;
        }

        if (deliveryMethodHidden && deliveryMethodHidden.value === 'DELIVERY') {
          updateFee(lat, lng);
        }
      }

      function handleMapClick(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        setLoading(true);
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
            setLocation(lat, lng, data.displayName);
          })
          .catch(() => {
            setLocation(lat, lng, lat + ', ' + lng);
          })
          .finally(() => {
            setLoading(false);
          });
      }

      map.on('click', handleMapClick);

      function toggleDeliverySection() {
        const method = deliveryMethodHidden ? deliveryMethodHidden.value : 'PICKUP';
        if (deliveryAddressSection) {
          deliveryAddressSection.classList.toggle('d-none', method !== 'DELIVERY');
        }
        if (method === 'PICKUP') {
          if (deliveryFeeDisplay) deliveryFeeDisplay.classList.add('d-none');
          if (deliveryFeeInput) deliveryFeeInput.value = '0';
        } else {
          const lat = parseFloat(latitudeInput.value);
          const lng = parseFloat(longitudeInput.value);
          if (!isNaN(lat) && !isNaN(lng)) {
            updateFee(lat, lng);
          }
        }
      }

      if (pickupRadio) {
        pickupRadio.addEventListener('change', () => {
          if (deliveryMethodHidden) deliveryMethodHidden.value = 'PICKUP';
          toggleDeliverySection();
        });
      }
      if (deliveryRadio) {
        deliveryRadio.addEventListener('change', () => {
          if (deliveryMethodHidden) deliveryMethodHidden.value = 'DELIVERY';
          toggleDeliverySection();
        });
      }

      if (input) {
        let timeout;
        input.addEventListener('input', function () {
          clearTimeout(timeout);
          timeout = setTimeout(searchAddress, 400);
        });
      }

      function searchAddress() {
        if (!input) return;
        const query = input.value.trim();
        if (query.length < 3) return;

        setLoading(true);
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
            const lat = parseFloat(data.latitude);
            const lng = parseFloat(data.longitude);
            setLocation(lat, lng, data.displayName);
          })
          .catch((err) => console.log('Search error:', err))
          .finally(() => {
            setLoading(false);
          });
      }
    }
    window.initMap = initMap;

    document.addEventListener('DOMContentLoaded', function () {
      initMap();
    });
  </script>

  {{-- Google Maps - Ready (add GOOGLE_MAPS_API_KEY to .env) --}}
  @endpush
