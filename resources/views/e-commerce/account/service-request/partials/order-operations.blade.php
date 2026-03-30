@php
    $canRequestTransport = true;
    $approvedTransport = false;

    foreach($order->transportRequests as $tRequests) {
        if($tRequests->user_id == auth()->id()) {
            if($tRequests->status == \App\Models\TransportRequest::STATUS_APPROVED) {
                $approvedTransport = true;
            }

            if($order->has_transport_cost == 0) {
                $approvedTransport = true;
            }
            $canRequestTransport = false;
        }
    }
@endphp
@if($order->has_transport_cost == 1)
    <template>
    @if($canRequestTransport && ($order->transportRequests->count() == 0 || $order->transportRequests->where('user_id', auth()->id())->first() == null) )
        <a class="btn btn-sm btn-primary" href="{{ route('service-requests.request-transport', $order->id) }}" class="card-link">
            Request for transport
        </a>
    @elseif(!$approvedTransport)
        <span class="badge bg-success">Transport Requested</span>
    @endif
    </template>
@endif

<!--TODO change below to order status in array -->
@if($approvedTransport && $order->status < App\Models\Order::STATUS_PENDING_SERVICE)
    <a class="btn btn-sm btn-primary" href="{{ route('service-requests.complete', $order->id) }}" class="card-link">
        Complete
    </a>
@endif
@if($order->has_transport_cost == 0 && $order->status <= App\Models\Order::STATUS_PENDING_SERVICE)
    <a class="btn btn-sm btn-primary" href="{{ route('service-requests.complete', $order->id) }}" class="card-link">
        Complete
    </a>
@endif
