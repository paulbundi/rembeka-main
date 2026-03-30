@extends('layouts.dashboard')
@section('content')

<h1 class="text-center" >{{ $menu->name }} </h1>
<div class="w-100 d-flex justify-content-center align-items-center" style="height:70vh;">

    {!! QrCode::size(300)->generate(url('/').'/browse-by-menu/'.$menu->id) !!}

</div>

@endsection

