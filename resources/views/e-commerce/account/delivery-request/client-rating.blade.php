@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container mb-2">
        <div class="row">
          @include('layouts.account-partial')
          <section class="col-lg-8">
            <div class="row card">
                <div class="col-12 card-body">
                    <h4>Complete Service</h4>
                    <form method="POST" action="{{ route('service-request.rating') }}">
                        @csrf
                        <input type="hidden" name="order_id" :value="{{ $order->id }}"/>
                        <!-- <div class="mb-3">
                            <label>Customer OTP</label>
                            <input class="form-control" name="otp" required>
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label" for="review-rating">Rating<span class="text-danger">*</span></label>
                            <select class="form-select" required id="review-rating" name="rating" >
                                <option value="">Choose rating</option>
                                <option value="5">5 stars</option>
                                <option value="4">4 stars</option>
                                <option value="3">3 stars</option>
                                <option value="2">2 stars</option>
                                <option value="1">1 star</option>
                            </select>
                            <div class="invalid-feedback">Please choose rating!</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="review-text">Review<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="6" required id="review-text" name="comment"></textarea>
                            <div class="invalid-feedback">Please write a review!</div><small class="form-text text-muted">Your review must be at least 50 characters.</small>
                        </div>

                        <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Submit a Review</button>

                    </form>
                </div>
            </div>
          </section>

        </div>
    </div>
</main>
@endsection