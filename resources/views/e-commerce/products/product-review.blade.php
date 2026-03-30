<div class="row pt-4">
    <!-- Reviews list-->
    <div class="col-md-7">
        <!-- Review-->
        @foreach($reviews as $review)
        <div class="product-review pb-4 mb-4 border-bottom">
            <div class="d-flex mb-3">
                <div class="d-flex align-items-center me-4 pe-2">
                    <user-icon :user="{{ $review->user }}" />
                    <span class="fs-ms text-muted">{{$review->created_at}}</span>
                </div>
                <div>
                <div class="star-rating">
                    <rating :rating="{{$review->rating}}" :size="20" />
                </div>
                </div>
            </div>
            <p class="fs-md mb-2">{{$review->comment}}</p>
        </div>
        @endforeach

        <div class="text-center">
            ...
        </div>
    </div>

    @auth
    <!-- Leave review form-->
    <div class="col-md-5 mt-2 pt-4 mt-md-0 pt-md-0">
        <div class="bg-secondary py-grid-gutter px-grid-gutter rounded-3">
        <h3 class="h4 pb-2">Write a review</h3>
        <form method="post" action="{{ route('product-review.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}" />
            <div class="mb-3">
            <label class="form-label" for="review-rating">Rating<span class="text-danger">*</span></label>
            <select class="form-select" required id="review-rating" name="rating" required>
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
    @endauth
</div>