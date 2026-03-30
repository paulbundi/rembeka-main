<div>
    <div class="card w-100">
        <h6 class="card-header">Provider Details</h6>
        <img class="card-img-top" src="{{ asset('img/logo-large.png') }}" alt="rembeka">
        <div class="card-body h-100">
            <b class="card-title">{{ $productPricing->provider->name }}</b>
            <rating :rating="{{4}}" :size="{{20}}"/>
            <p class="card-text">professional_qualifications</p>
            <p class="card-text">professional_qualifications</p>
        </div>
    </div>
</div>