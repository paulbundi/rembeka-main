<div class="row border-top border-bottom">
    <div class="col-8">
    <small>Item:</small> {{$item->product->name}}<br/>
    <small>Date:</small> {{$item->appointment_date}}<br/>
    <small>Time:</small> {{$item->appointment_time}}<br/>
    @if($item->assisting_provider_id != null)
        @if($item->assisting_provider_id == auth()->user()->organization_id)
            <span class="badge bg-info fw-bold">Assisting:</span> <small class="fw-bolder">{{$item->provider->name}}</small>
        @else
            <span class="badge bg-info fw-bold">Assisting:</span>: <small class="fw-bolder">{{$item->assistingProvider->name}}</small>
        @endif
    @endif
    </div>
    <div class="col-4">
    Qty: {{$item->quantity}}

   

    </div>
</div>