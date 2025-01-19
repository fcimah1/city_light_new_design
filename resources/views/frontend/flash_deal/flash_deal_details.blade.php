@extends('new.layout')
@section('content')


    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home </a>
                        <a href="{{ url('/flash_deals') }}"> Flash Deals </a>
                        <span> {{ $flash_deal->title }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <div class="blog-detail-title">



                            <h2> {{ $flash_deal->title }} </h2>
                            <p> Duration : <span>- {{ date('d/m/Y', $flash_deal->start_date) }}
                                    ,{{ date('d/m/Y', $flash_deal->end_date) }}</span></p>
                        </div>
                        <div class="blog-large-pic">


                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ uploaded_asset($flash_deal->banner) }}" alt="{{ $flash_deal->title }}"
                                class="lazyload">
                        </div>


                        <section class="mb-4">
                            <div class="container">
                                <div class="text-center my-4 text-{{ $flash_deal->text_color }}">
                                    <h1 class="h2 fw-600">{{ $flash_deal->title }}</h1>
                                    <div class="aiz-count-down aiz-count-down-lg ml-3 align-items-center justify-content-center"
                                        data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                                </div>
                                @if ($flash_deal->status == 1 && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
                                    <div
                                        class="row gutters-5 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
                                        @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                                            @php
                                                $product = \App\Models\Product::find($flash_deal_product->product_id);
                                            @endphp
                                            @if ($product->published != 0)
                                                <div class="col mb-2">
                                                    @include(
                                                        'frontend.partials.index_flash_product_model',
                                                        ['product' => $product]
                                                    )
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="h4">{{ translate('This offer has been expired.') }}</p>
                                @endif

                            </div>
                        </section>



                    </div>
                </div>
            </div>
        </div>
    </section>





@endsection
