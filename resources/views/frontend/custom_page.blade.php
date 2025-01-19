@extends('frontend.layout')
@section('content')


    <div class="breacrumb-section banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> {{__('front.home')}}</a>
                        <span>{{ $page->title}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="mb-4">
        <div class="container">
            <div class="p-4 bg-white rounded shadow-sm overflow-hidden mw-100 text-left">
                {!! Blade::compileString( $page->content) !!}

            </div>
        </div>
    </section>

@endsection


@section('script')
    <script src="{{asset('new')}}/js/jquery-3.3.1.min.js"></script>
    <script src="{{asset('new')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('new')}}/js/jquery-ui.min.js"></script>
    <script src="{{asset('new')}}/js/jquery.countdown.min.js"></script>
    <script src="{{asset('new')}}/js/jquery.nice-select.min.js"></script>
    <script src="{{asset('new')}}/js/jquery.zoom.min.js"></script>
    <script src="{{asset('new')}}/js/jquery.dd.min.js"></script>
    <script src="{{asset('new')}}/js/jquery.slicknav.js"></script>
    <script src="{{asset('new')}}/js/owl.carousel.min.js"></script>
    <script src="{{asset('new')}}/js/main.js"></script>


@endsection

