<section class="tns-carousel mb-3 mb-md-5">
    <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 1, &quot;mode&quot;: &quot;gallery&quot;, &quot;nav&quot;: false, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 3000, &quot;responsive&quot;: {&quot;0&quot;: {&quot;nav&quot;: true, &quot;controls&quot;: false}, &quot;576&quot;: {&quot;nav&quot;: false, &quot;controls&quot;: true}}}">
        <!-- Slide 1-->
        <div>
        <div class="rounded-3 px-md-5 text-center text-xl-start" style="background-color: #c12c5d;">
            <div class="d-xl-flex justify-content-between align-items-center px-4 px-sm-5 mx-auto" style="max-width: 1226px;">
            <div class="py-5 me-xl-4 mx-auto mx-xl-0" style="max-width: 490px;">
                <h2 class="h1 text-light">Tired of long queues at salons!</h2>
                <h4 class="text-light pb-4 h-4">Do you need beauty services, Nails, Hair done?</h4>
                 <div class="d-flex align-items-center">
                    <a href="https://wa.me/{{config('services.whatsapp.rembeka_whatsapp_no')}}?text={{ urlencode(url()->current()) }}" target="_blank">
                        <img src="{{ asset('img/whatsapp.png') }}" width="50px" height="50px" alt="talk to us on whatsapp" />
                    </a>

                    <a class="btn text-light pb-4 h-5 ps-0" href="tel:+{{config('services.whatsapp.rembeka_whatsapp_no')}}">
                        <i class="bi bi-telephone fs-4 me-1"></i>
                        +{{config('services.whatsapp.rembeka_whatsapp_no')}}
                    </a>
                </div>
                <div class="">
                    <a href="/search/" class="btn btn-sm text-white bg-dark">Book Now</a>
                </div>
            </div>
            <div><img src="img/landingpage.png" alt="Image" style="max-height: 490px;"></div>
            </div>
        </div>
        </div>
        <!-- Slide 2-->
        <div>
        <div class="rounded-3 px-md-5 text-center text-xl-start" style="background-color: #c12c5d;">
            <div class="d-xl-flex justify-content-between align-items-center px-4 px-sm-5 mx-auto" style="max-width: 1226px;">
            <div class="py-5 me-xl-4 mx-auto mx-xl-0" style="max-width: 490px;">
                <h2 class="h1 text-light">Rembeka</h2>
                <h4 class="text-light pb-4">Treat yourself to unique Hair styles and nail designs at affordable rates.</h4>
                <div class="d-flex align-items-center">
                    <a href="https://wa.me/{{config('services.whatsapp.rembeka_whatsapp_no')}}?text={{ urlencode(url()->current()) }}" target="_blank">
                        <img src="{{ asset('img/whatsapp.png') }}" width="50px" height="50px" alt="talk to us on whatsapp" />
                    </a>

                    <a class="btn text-light pb-4 h-5 ps-0" href="tel:+{{config('services.whatsapp.rembeka_whatsapp_no')}}">
                        <i class="bi bi-telephone fs-4 me-1"></i>
                        +{{config('services.whatsapp.rembeka_whatsapp_no')}}
                    </a>
                </div>
                <div class="">
                    <a href="/search/" class="btn btn-sm text-white bg-dark">Book Now</a>
                </div>
            </div>
            <div><img src="img/hair.png" alt="Image"></div>
            </div>
        </div>
        </div>
    </div>
</section>