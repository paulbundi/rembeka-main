@extends('layouts.e-commerce')
@push('css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endpush
@section('seo')
 <!-- Primary Meta Tags -->
 @if(isset($seoSource) && $seoSource->name)
 <meta name="title" content="Rembeka - {{$seoSource->name}}">
<meta name="description" content="Home services for  {{$seoSource->name}}">
<meta name="keywords" content="Hairstyles in near me,salons near me, hairstyles in kenya, Salon in Kenya, makeup, Event makeup,
Hairstyles, new hair styles, Haircare, Makeup services in Kenya, Nail artists, Nail artists in Kenya, Homecare,
Online Salon, Free booking, Home appointment, Hair at home, Hair tips, rembeka Kenya, Pregnant women Hair,
Mothers Hair, Kids hairstyles, Children hairstyles, Children booking, Children Hair home, Mother Hair home">
 @else
 <meta name="title" content="Rembeka - ">
<meta name="description" content="Get all beauty servives at home">
<meta name="keywords" content="Hairstyles in near me,salons near me, hairstyles in kenya, Salon in Kenya, makeup, Event makeup,
Hairstyles, new hair styles, Haircare, Makeup services in Kenya, Nail artists, Nail artists in Kenya, Homecare,
Online Salon, Free booking, Home appointment, Hair at home, Hair tips, rembeka Kenya, Pregnant women Hair,
Mothers Hair, Kids hairstyles, Children hairstyles, Children booking, Children Hair home, Mother Hair home">
@endif

@endsection
@section('content')

<main>
    <div class="container" style="margin-top:6em;">
        <product-search-page  :category="'{{$category ?? "null"}}'" :menu="'{{$menu ?? "null"}}'" :search-query="'{{$searchStr?? ''}}'"/>
    </div>
</main>
@endsection