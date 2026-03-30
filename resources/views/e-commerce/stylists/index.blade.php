@extends('layouts.e-commerce')
@section('content')
<main class="" style="padding-top: 5rem;">
    <section class="ps-lg-4 pe-lg-3 pt-4">
        <div class="px-3 pt-2">
            <div class="row">
             <div class="col-12">
                    <div class="alert alert-success">
                        <a href="{{ route('stylists.inquire') }}">I am interested in join as a Service Provider</a>
                    </div>
                </div>
                <!-- stylists-->
                @foreach($stylists as $stylist)
                <div class="col-lg-4 col-sm-6">
                    <div class="card mb-1">
                        <div class="d-flex align-items-center card-body p-1">
                            @if($stylist->profile && $stylist->profile->attachments && $stylist->profile->attachments->count() > 0)
                                <img class="rounded-circle" src="{{ asset($stylist->profile->attachments->first()->media->url) }}" width="150" alt="{{$stylist->name}}">
                            @else
                                <img class="rounded-circle" src="{{ asset('img/default.png') }}" width="150" height="150" alt="{{$stylist->name}}">
                            @endif
                            <div class="ps-3">
                                <h6 class="fs-base pt-1 mb-1">{{ $stylist->first_name }} {{ $stylist->last_name }}</h6>
                                @if($stylist->profile)
                                <small>{{ $stylist->profile->professional_qualifications }}</small><br/>
                                @endif
                                <a class="btn btn-primary btn-sm btn-shadow mt-3" href="{{ route('stylist.show', $stylist->slug) }}">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- stylists-->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $stylists->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection