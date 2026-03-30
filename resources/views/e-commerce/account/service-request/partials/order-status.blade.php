<div>
    <small>#</small><small class="fs-6 fw-bold">{{ $order->order_no }}</small><br/>
<!--TODO change below to orderstatus in array -->
    @if($order->status > App\Models\Order::STATUS_PENDING_SERVICE)
        <small class="badge bg-success" class="card-link">
        Complete
        </small>
    @endif
</div>