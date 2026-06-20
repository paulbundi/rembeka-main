@extends('layouts.e-commerce')

@section('seo')
@include('layouts.common-seo')
@endSection
@section('content')
    <main style="padding-top: 3.5rem;">
        <section class="px-md-4">
            <div class="px-3 pt-2">
                @include('e-commerce.sliders.welcome-slider')
                @include('e-commerce.categories-grid')
                @include('e-commerce.trust-badges')
                @include('e-commerce.sliders.best-seller')
                @include('e-commerce.special-offers')
                @include('e-commerce.sliders.discouted-products')
                @include('e-commerce.sliders.our-partners')
                @include('e-commerce.footer-pink-bar')
                @include('layouts.e-commerce-footer')
            </div>
        </section>
    </main>

    @if(isset($activeAd) && $activeAd != null)
        <!-- Modal -->
        <div class="modal fade" id="advertModal" tabindex="-1" aria-labelledby="advertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img class="rounded" src="{{ optional(optional($activeAd->attachments->first())->media)->url }}"
                            style="max-height:70vh !important" />
                    </div>
                    <div class="modal-footer">
                        <input type="checkbox" id="permentenly-hide-modal" name="hidemodal"><small>Don`t show again</small>
                        <a href="{{$activeAd->call_to_action_url}}" id="per"
                            class="btn btn-primary">{{$activeAd->call_to_action}}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')

    <script>

        let isModalVisible = localStorage.getItem("adModalIsVisible");

        if (!isModalVisible) {
            const myModal = new bootstrap.Modal(document.getElementById('advertModal'), {})
            myModal.show();
        }

        $('#permentenly-hide-modal').click(function (e) {
            if (e.target.value == 'on') {
                localStorage.setItem("adModalIsVisible", true);
            }
        });
    </script>
@endpush