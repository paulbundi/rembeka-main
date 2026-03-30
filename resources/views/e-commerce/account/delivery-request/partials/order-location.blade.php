@if($order && $order->address)
    <p class="card-text">
        location: {{ $order->address->name }}<br/>
        @if($order->address->floor)
        <small>Floor:</small> {{ $order->address->floor }} <br/>
        @endif

        @if($order->address->room)
        <small>Room No:</small> {{ $order->address->room }}
        @endif
    </p>
@endif