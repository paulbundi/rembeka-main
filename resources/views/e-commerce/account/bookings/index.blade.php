@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8">
            <div class="row mb-2">
                <div class="col-12 card w-100">
                    <div class="card-header px-0">
                        <b>Make Reservation</b>
                        <form method="post" action="{{ route('book-slots.store')}}">
                            @csrf
                            <div class="d-flex">
                                <select class="form-control" name="service_id" required="true">
                                    <option value=""></option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->product->name  }}</option>
                                    @endforeach
                                </select>
                                <input type="datetime-local" name="slot_time" class="form-control" placeholder="reservation time" required="true"/>
                                <button type="submit" class="btn btn-sm btn-primary">Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
              @foreach($bookings as $booking)
                <div class="col-12 col-sm-5 mb-1 card">
                  <div class="card-body px-1">
                     <b>Service:</b> {{$booking->providerPricing->product->name}}<br/>
                     <b>Date:</b> {{date_format($booking->slot_time, 'Y,M-d H:m A')}}<br/>
                     <b>Status:</b> 
                     @if($booking->confirmation_status == \App\Models\Booking::STATUS_CONFIRMED)
                        <span class="badge bg-success">Confirmed</span>
                     @else
                        <span class="badge bg-warning">Pending</span>
                     @endif
                  </div>
                </div>
              @endforeach
            </div>
            {{ $bookings->links()}}
          </section>

        </div>
    </div>
</main>
@endsection