@extends('layouts.e-commerce')
@section('seo')
 <!-- Primary Meta Tags -->
 <meta name="title" content="Rembeka -{{$product->name}}">
<meta name="description" content="{{$product->seo_title}}, {{$product->seo_description}} ">
<meta name="keywords" content="Buy, salons near me, homecall,free delivery Nairobi, {{$product->keywords}}">

@endsection
@section('content')
<main style="padding-top: 5rem;">
  <section class="ps-lg-4 pe-lg-3 pt-4">
    <div class="px-3 pt-2">
      <!-- Page title + breadcrumb-->
      <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb flex-lg-nowrap">
          <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="ci-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="{{route('browse-by-menu.index', $product->menu->id)}}">{{$product->menu->name}}</a>
          </li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page">{{$product->name}}</li>
        </ol>
      </nav>
      <!-- Content-->
      <!-- Product Gallery + description-->
      <section class="row g-0 mx-n2 pb-5 mb-xl-3">
        <div class="col-xl-2">
          @if(auth()->check() && $product->advert)
          <div class="card">
          <img class="card-img-top" src="{{$product->advert->attachments->first()->media->url}}"/>
            <div class="card-body">
              <a href="https://wa.me/254789311440?text={{$product->advert->name}}" class="btn btn-primary">{{ $product->advert->call_to_action }}</a>
            </div>
          </div>
          @endif
        </div>
        <div class="col-xl-5 px-2 mb-3">
          <div class="h-100 bg-light rounded-3 p-4">
            <div class="product-gallery">
              <div class="product-gallery-preview order-sm-2">
                @foreach($product->attachments as $key => $attachment)
                  @if($attachment->media)
                    <div class="product-gallery-preview-item @if($key == 0) active @endif" id="first{{$attachment->id}}">
                      <img src="{{ asset($attachment->media->url)}}" alt="Product image">
                    </div>
                  @endif
                @endforeach
              </div>
              <div class="product-gallery-thumblist order-sm-1">
              @foreach($product->attachments as $attachment)
                @if($attachment->media)
                  <a class="product-gallery-thumblist-item @if($key == 0) active @endif" href="#first{{$attachment->id}}">
                    <img src="{{ asset($attachment->media->url)}}" alt="Product thumb">
                  </a>
                @endif
              @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-5 px-2 mb-3">
          <add-to-cart-view :product="{{ $product }}" @if($provider)  :provider-selected="{{ $provider }}" @endif/>
        </div>
      </section>
      <!-- Related products-->
      @include('e-commerce.products.related-products')
    </div>

    <div class="container">
      @include('e-commerce.products.product-review')
    </div>
  </section>
</main>
@endsection