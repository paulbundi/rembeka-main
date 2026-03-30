@if($order->location && $order->location->address)
    <p class="card-text">
        {{ $order->location->address->name }}
        @if($order->location->address->floor)
        <small>Floor:</small> {{ $order->location->address->floor }} 
        @endif

        @if($order->location->address->room)
        <small>Room No:</small> {{ $order->location->address->room }}
        @endif
    </p>
@endif