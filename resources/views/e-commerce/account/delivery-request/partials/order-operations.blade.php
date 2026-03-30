
<div class="col-12">
@if($order->deliveryRequests && $order->deliveryRequests->count() == 0)
    <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bolder">{{ $order->delivery_amount}}</span>
        <a class="btn btn-sm btn-primary" href="{{ route('delivery-requests.request-transport', $order->id) }}" class="card-link">
            Request for transport
        </a>
    </div>
@elseif($order->deliveryRequests && $order->deliveryRequests &&  $order->deliveryRequests->first()->status == App\Models\DeliveryRequest::STATUS_PENDING)
    <span class="badge bg-success">Delivery Fee Requested</span>
@elseif($order->deliveryRequests && $order->deliveryRequests &&  $order->deliveryRequests->first()->status == App\Models\DeliveryRequest::STATUS_APPROVED)
    <span class="badge bg-success">Delivery Fee Issued</span>
@endif
</div>

