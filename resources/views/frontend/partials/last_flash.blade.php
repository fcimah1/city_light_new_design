
<!--<div class="mb-4">-->
<!--    <div class="container">-->
<!--        <div class="row gutters-10">-->
<!--            @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp-->
<!--            @foreach($flash as $single)-->
<!--                <div class="col-xl col-md-6">-->
<!--                    <div class="mb-3 mb-lg-0">-->
<!--                        <a href="{{ route('flash-deal-details', $single->slug) }}" class="d-block text-reset">-->
<!--                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"-->
<!--                                 data-src="{{ uploaded_asset($single->banner) }}"-->
<!--                                 alt="{{ $single->title }}"-->
<!--                                 class="img-fluid lazyload w-100">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            @endforeach-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="mb-4">
    <div class="container">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">

                <h3 class="h5 fw-700 mb-0">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Last Deals')}}</span>
                </h3>
                <a href="{{ route('flash-deals') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Deals') }}</a>

            </div>

            <div class="row gutters-10">
                @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                @foreach($flash as $single)
                    <div class="col-xl col-md-6">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ route('flash-deal-details', $single->slug) }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                     data-src="{{ uploaded_asset($single->banner) }}"
                                     alt="{{ $single->title }}"
                                     class="img-fluid lazyload w-100">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>






    </div>
</div>