@extends('layouts.dashboard')
@section('content')
<{{ $page }}
    @foreach(['id', 'param2', 'param3'] as $attribute)
        @if(!empty($$attribute))
            :{{ $attribute }}="{{ $$attribute }}"
        @endif
    @endforeach
>
</{{ $page }}>
@endsection

