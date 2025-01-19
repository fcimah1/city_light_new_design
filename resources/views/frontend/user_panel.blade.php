@extends('frontend.layout')
@section('content')





    <div class="breacrumb-section banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> {{__('front.home')}}</a>
                        <span>User Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="product-shop spad">
        <div class="container">
            <div class="row">



                <div class="col-lg-3 col-md-6 col-sm-6 aiz-user-panel">
                    @include('frontend.inc.user_side_nav')
                </div>

                <div class="col-lg-9 col-md-6 col-sm-6 aiz-user-panel ">


                    @yield('panel_content')
                </div>





            </div>
        </div>
    </section>

    <section class="container py-5" style="border-bottom: 0.5px gainsboro solid ">
    <!--end title detail-->



    </section>
@endsection




