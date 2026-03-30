@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8">
            @if(isset($address))
                <form method="POST" action="{{ route('addresses.update',$address->id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('addresses.store')}}">
            @endif
            @csrf
              <div class="row gx-4 gy-3">

                <div class="col-12">
                  <div id="pac-container">
                    <label>Enter Your Location</label>
                    <input id="pac-input" name="name" type="text" placeholder="Enter a location" class="form-control" value="{{old('name', isset($address) ? $address->name: '')}}" />
                    <input type="hidden" name="lat_long"  id="lat_long"/>
                  </div>
                  <div id="map" style="height: 250px;"></div>
                  <div id="infowindow-content">
                    <span id="place-name" class="title"></span><br />
                    <span id="place-address"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-ln">Appartment</label>
                  <input class="form-control" type="text" name="appartment" id="account-ln" value="{{old('appartment',isset($address) ? $address->appartment: '')}}">
                  @error('appartment')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-floor">floor</label>
                  <input class="form-control" type="text" name="floor" id="account-floor" value="{{old('floor',isset($address) ? $address->floor: '')}}">
                  @error('floor')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-room">Room</label>
                  <input class="form-control" type="text" name="room" id="account-room"  value="{{old('room', isset($address) ? $address->room: '')}}">
                  @error('room')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-12">
                  <hr class="mt-2 mb-3">
                    <button class="btn btn-primary mt-3 mt-sm-0" type="submit">@if(isset($address)) update @else Create @endif address</button>
                  </div>
                </div>
              </div>
            </form>
         
          </section>

        </div>
    </div>
</main>
@endsection

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
  const biasInputElement = document.getElementById("use-location-bias");
  const strictBoundsInputElement = document.getElementById("use-strict-bounds");
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
  biasInputElement.addEventListener("change", () => {
    if (biasInputElement.checked) {
      autocomplete.bindTo("bounds", map);
    } else {
      // User wants to turn off location bias, so three things need to happen:
      // 1. Unbind from map
      // 2. Reset the bounds to whole world
      // 3. Uncheck the strict bounds checkbox UI (which also disables strict bounds)
      autocomplete.unbind("bounds");
      autocomplete.setBounds({ east: 180, west: -180, north: 90, south: -90 });
      strictBoundsInputElement.checked = biasInputElement.checked;
    }

    input.value = "";
  });
  strictBoundsInputElement.addEventListener("change", () => {
    autocomplete.setOptions({
      strictBounds: strictBoundsInputElement.checked,
    });
    if (strictBoundsInputElement.checked) {
      biasInputElement.checked = strictBoundsInputElement.checked;
      autocomplete.bindTo("bounds", map);
    }

    input.value = "";
  });
}

window.initMap = initMap;
  </script>
@endpush