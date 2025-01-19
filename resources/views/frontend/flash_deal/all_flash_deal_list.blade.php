@extends('new.layout')

@section('content')

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                        <span>Flash Deals</span>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <section class="blog-section spad">
        <div class="container">
            <div class="row">

                @if(count($all_flash_deals)>0)

                <div class="col-lg-12 order-1 order-lg-2">
                    <div class="row">

                        @foreach ($all_flash_deals as $single)


                            <div class="col-lg-6 col-sm-6">
                                <div class="blog-item">
                                    <div class="bi-pic">

                                        <a href="{{ route('flash-deal-details', $single->slug) }}">
                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                             data-src="{{ uploaded_asset($single->banner) }}"
                                             alt="{{ $single->title }}"
                                             class="lazyload">

                                        </a>

                                    </div>
                                    <div class="bi-text">
                                        <a href="{{ route('flash-deal-details', $single->slug) }}">
                                            <h4> {{ $single->title }}</h4>
                                        </a>

                                        <p>From : {{ date('d/m/Y',$single->start_date) }} <span>-   </span>{{ date('d/m/Y',$single->end_date) }}</p>
                                        <p> </p>
                                    </div>
                                </div>
                            </div>



                        @endforeach





                        <div class="col-lg-12">
                            <div class="loading-more">

                                {{ $all_flash_deals->links() }}

                            </div>
                        </div>
                    </div>
                </div>

                    @else
                        <div class="col-lg-9 order-1 order-lg-2 offset-3">
                            <div class="row">
                                <div class="error">



                                    <div class="card-img-top">
                                        <a href="#" class="wp-post-image">
                                            <img class="image-cover"  src="{{ static_asset('assets/img/nothing.svg') }}" alt="product">
                                        </a>


                                    </div>
                                    <div class="card-body">

                                        <p class="woocommerce-loop-product__title">

                                            Oops!


                                        </p>

                                        <h2>No Flash Deals</h2>
                                        <span>Wait Flash Deals Soon.</span>

                                    </div>



                                </div>
                            </div>
                        </div>

                    @endif

            </div>
        </div>
    </section>
@endsection
