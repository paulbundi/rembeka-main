@extends('layouts.e-commerce')
@section('content')
<div class="container py-4 py-lg-5 my-4">
    <div class="row">
        @include('e-commerce.signin')
        @include('e-commerce.signup')
    </div>
</div>
@endsection