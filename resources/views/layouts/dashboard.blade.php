<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Rembeka Dashboard">
	<meta name="author" content="njenga55@gmail.com">
    <meta name="csrf-token" value="{{ csrf_token() }}"  content="{{ csrf_token() }}"/>
    <meta name="api-url" content="{{ config('app.url') . '/system' }}">

	<title>Rembeka-dashboard</title>
	<link href="{{ asset('admin-dashboard/css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @stack('css')
    <style>
        body{
            font-size: 14px !important;
        }
    </style>
</head>
<!--
  HOW TO USE: 
  data-theme: default (default), dark, light
  data-layout: fluid (default), boxed
  data-sidebar: left (default), right
-->

<body data-theme="default" data-layout="fluid" data-sidebar="left">
    <div id="app-dashboard">
        <div class="wrapper">
            @include('dashboard.nav.left-side-nav')
            <div class="main pe-1">
                @include('dashboard.nav.top-nav-bar')
                <main class="content" style="max-height: 90vh; overflow-y:scroll;">
                    <div class="container-fluid p-0">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        <confirm-dialog/>
    </div>
    <script>
        window.store = @if(!empty($store)) {!! $store !!} @else {{ '{}' }} @endif;
        window.vuex = @if(!empty($vuex)) {!! $vuex !!} @else {{ '{}' }} @endif;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="{{ mix('admin-dashboard/js/app.js') }}"></script>

    <script>
       const pathName =  window.location.pathname.split('/');
       let element = document.querySelector(`a[href*=${pathName[1]}]`)
       if(element) {
            element.classList.add('active');
       }else if(pathName.length > 2  && !element) {
        let element = document.querySelector(`[href*=${pathName[2]}]`)
        element.classList.add('active');

       }
    </script>

@if(session()->has('message'))
    <script>
        $(function() {
            toastr.options.timeOut = "false";
            toastr.options.closeButton = true;
            toastr.options.timeOut=3000;
            toastr.options.positionClass = 'toast-top-right';
            toastr['{{ session()->get('message.type') }}']('{{ session()->get('message.message') }}');
        });
    </script>
@endif
<script>
$(function() {
    let activeMenu = document.getElementsByClassName('sidebar-link active');
        if(activeMenu && activeMenu.length > 0) {
            activeMenu[0].scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
        }
});
</script>
@stack('scripts')
</body>