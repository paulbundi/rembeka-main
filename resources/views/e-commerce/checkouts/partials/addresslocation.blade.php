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
        <input id="pac-input" name="name" type="text" placeholder="Enter a location" class="form-control"/>
        <input type="hidden" name="lat_long"  id="lat_long"/>
        </div>
        <div id="map" style="height: 250px;"></div>
        <div id="infowindow-content">
        <span id="place-name" class="title"></span><br />
        <span id="place-address"></span>
        </div>

      
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="account-ln">Apartment/Building/Estate<small>(required)</small></label>
        <input class="form-control" type="text" name="appartment" id="account-ln" value="{{old('appartment')}}">
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
        <input class="form-control" type="text" name="room" id="account-room"  value="{{old('room')}}">
        @error('room')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

</div>


@push('scripts')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
  src="https://maps.googleapis.com/maps/api/js?key={key}&callback=initMap&libraries=places&v=weekly"
  defer
></script>

<script>
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 40.749933, lng: -73.98633 },
    zoom: 13,
    mapTypeControl: false,
  });
  const card = document.getElementById("pac-card");
  const input = document.getElementById("pac-input");
  const options = {
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
  };

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

  const autocomplete = new google.maps.places.Autocomplete(input, options);
  autocomplete.bindTo("bounds", map);

  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });

  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    const latitude = place.geometry.location.lat();
    const longitude = place.geometry.location.lng();

    inputElement = document.getElementById('lat_long');

    if(inputElement) {
      inputElement.value = `${latitude}, ${longitude}`;
    }


    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
      place.formatted_address;
    infowindow.open(map, marker);
  });
}

window.initMap = initMap;
  </script>
@endpush