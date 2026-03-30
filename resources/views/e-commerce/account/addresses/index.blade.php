@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')
          <section class="col-lg-8">
            <div class="text-sm-end pb-2">
              <a class="btn btn-primary" href="{{ route('addresses.create') }}" >Add new address</a></div>
            <div class="row">
              @foreach($addresses as $address)
                <div class="col-12 col-sm-5 mb-1" style="min-height: 200px;" >
                  <div class="card card-body h-100">
                    <h5 class="card-title">{{ $address->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $address->name }}</h6>
                    <p class="card-text">
                      @if($address->floor)
                      <small>Floor:</small> {{ $address->floor }} 
                      @endif

                      @if($address->room)
                      <small>Room No:</small> {{ $address->room }}
                      @endif
                    </p>
                    <div class="d-flex justify-content-between mt-2 w-100" style="margin-bottom:5px;">
                      <form method="POST" action="{{ route('addresses.destroy', $address->id) }}">
                        @csrf
                        @method('DELETE')
                          <button class="btn btn-sm btn-primary" type="submit">
                            <i class="bi bi-trash2-fill"></i>
                            Delete
                          </button>
                      </form>

                      <a  class="btn btn-sm btn-success" href="{{ route('addresses.edit', $address->id) }}" class="card-link">
                        <i class="bi bi-pencil-square"></i>
                        edit
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
         
          </section>

        </div>
    </div>
</main>
@endsection