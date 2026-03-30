<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
        <!-- Viewport-->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="facebook-domain-verification" content="w9rps85dyo82gxzmfu9xhdc79tym0i" />
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <title>Rembeka | Conveniently Beautiful</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VSXZ9CMH05"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-VSXZ9CMH05');
    </script>
    <!-- SEO Meta Tags-->

    <script type='text/javascript'>
    // window.smartlook||(function(d) {
    //   var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    //   var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    //   c.charset='utf-8';c.src='https://web-sdk.smartlook.com/recorder.js';h.appendChild(c);
    //   })(document);
    //   smartlook('init', '198b87a8cf4c443eda157f5b46d144263f7bc7f4', { region: 'eu' });
  </script>
    <meta name="csrf-token" value="{{ csrf_token() }}"  content="{{ csrf_token() }}"/>
    <meta name="api-url" content="{{ config('app.url') }}">

    @yield('seo')
        
    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{ asset('vendor/tiny-slider/dist/tiny-slider.css') }}"/>
    <!-- Main Theme Styles + Bootstrap-->
    @stack('css')
    <!-- <link rel="stylesheet" media="screen" href="{{ asset('css/theme.min.css')}}"> -->
    <link rel="stylesheet" media="screen" href="{{ asset('css/app.css')}}">
  </head>
  <!-- Body-->
<body class="bg-secondary">
    <div id="app">
        <header class="bg-light shadow-sm fixed-top" data-fixed-element>
          @include('e-commerce.nav-bars.top-contact-us-bar')
          @include('e-commerce.nav-bars.header-with-search-bar')
        </header>
        
        @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
          @include('e-commerce.nav-bars.main-page-side-menu')
        @endif
        <div class="d-sm-none">
          @include('e-commerce.nav-bars.main-page-side-menu')
        </div>
        <div class="w-100" style="margin-top:30px !important;">
          @yield('content')
        </div>
        <div class="handheld-toolbar">
          <div class="d-table table-layout-fixed w-100">
          @if(
            \Illuminate\Support\Facades\Route::currentRouteName() == 'browse-by-categories.index' ||
            \Illuminate\Support\Facades\Route::currentRouteName() == 'search.index'
          ) 
            <a class="d-table-cell handheld-toolbar-item" href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#shop-sidebar">
              <span class="handheld-toolbar-icon">
                <i class="bi bi-funnel"></i>
              </span>
              <span class="handheld-toolbar-label">Filter</span>
            </a>
        
          @else
            <a class="d-table-cell handheld-toolbar-item" href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#sideNav">
              <span class="handheld-toolbar-icon">
              <i class="ci-menu"></i></span><span class="handheld-toolbar-label">Menu</span>
            </a>
          @endif

            <a class="d-table-cell handheld-toolbar-item" href="{{ route('wishlists.index') }}">
              <span class="handheld-toolbar-icon"><i class="ci-heart"></i>
                @if(auth()->check() && auth()->user()->liked  > 0)
                  <small class="badge bg-primary rounded-pill ms-1">{{ auth()->user()->liked }}</small>
                @endif
              </span>
              <span class="handheld-toolbar-label">Wishlist</span>
            </a>
            <div>
              <cart-hover footer-cart/>
            </div>

            @if(auth()->check() && auth()->user()->account_type == \App\Models\User::TYPE_PROVIDER)
              <a class="d-table-cell handheld-toolbar-item" href="{{ route('service-requests.index') }}">
                <span class="handheld-toolbar-icon">
                <i class="bi bi-truck"></i>
                <span class="badge bg-primary rounded-pill ms-1">{{ $orderItems }}</span>
                </span>
                <span class="handheld-toolbar-label">Orders</span>
              </a>
            @endif
          </div>
        </div>
    </div>

    <div class="whatsapp-mobile d-none" id="whatsapp-mobile">
      <a href="https://wa.me/{{config('services.whatsapp.rembeka_whatsapp_no')}}?text={{ urlencode(url()->current()) }}" target="_blank">
        <img src="{{ asset('img/whatsapp.png') }}" width="50px" height="50px" alt="talk to us on whatsapp" />
      </a>        
    </div>

    <div class="whatsapp-web" id="whatsapp-web">
      <a href="https://web.whatsapp.com/send?phone={{config('services.whatsapp.rembeka_whatsapp_no')}}&text={{urlencode(url()->current())}}" target="_blank">
        <img src="{{ asset('img/whatsapp.png') }}" width="60px" height="60px" alt="talk to us on whatsapp" />
      </a>
    </div>

    <a class="btn-scroll-top" href="#top" data-scroll data-fixed-element><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up">   </i></a>
    <script>
        window.store = @if(!empty($store['cart'])) {!! $store['cart'] !!} @else {{ '{}' }} @endif;
    </script>  
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}"></script>

      <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/tiny-slider/dist/min/tiny-slider.js') }}"></script>
    <script src="{{ asset('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
    <!-- Main theme script-->
    <script src="{{ asset('js/theme.min.js') }}"></script>

    <script>
      window.addEventListener('load', (event) => {
        window.mobileCheck = function() {
            let check = false;
            (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|iP(hone|od)|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
           
            return check;
          };
          if(window.mobileCheck()) {
            document.getElementById('whatsapp-web').classList.add('d-none')
            document.getElementById('whatsapp-mobile').classList.remove('d-none')
          }
      });
    </script>

    @if(session()->has('message'))
        <script>
          $(function() {
            toastr.options.timeOut = "false";
            toastr.options.closeButton = true;
            toastr.options.timeOut=4000;
            toastr.options.positionClass = 'toast-top-right';
            toastr['{{ session()->get('message.type') }}']('{{ session()->get('message.message') }}');
          });
        </script>
    @endif
    <script>
      $(function() {
        function getCookie(name) {
          var nameEQ = name + "=";
          var ca = document.cookie.split(';');
          for(var i=0;i < ca.length;i++) {
              var c = ca[i];
              while (c.charAt(0)==' ') c = c.substring(1,c.length);
              if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
          }
          return null;
        }

        function setCookie(value){
          var date = new Date();
              date.setTime(date.getTime() + (365*24*60*60*1000));
              expires = "; expires=" + date.toUTCString();
              document.cookie = 'activeMenuItem' + "=" + (value || "")  + expires + "; path=/";
              $(".products-tab").removeClass('show active');
              $(".services-tab").removeClass('show active');
              $(`.${value}-tab`).addClass('show active');
        }

        if(getCookie('activeMenuItem')) {
          const activeMenu = getCookie('activeMenuItem');
          if(activeMenu) {
              $(`.${activeMenu}-tab`).addClass('show active');
              $(`.${activeMenu}-list`).addClass('active');
          }
        }else {
          setCookie('services');
          $('.services-list').addClass('active');
        }

        $(".preference-menu").click(function(e) {
          let value = $(this).attr('id');
          if(value){
            setCookie(value);
          }
          
        });
      });
    </script>
    {!! NoCaptcha::renderJs() !!}

    @stack('scripts')
</body>