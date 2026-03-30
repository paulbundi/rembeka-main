@extends('layouts.e-commerce')
@push('css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endpush
@section('content')

<main>
    <div class="container" style="margin-top:6em;">
        <product-treasure-page/>
    </div>
</main>
@endsection