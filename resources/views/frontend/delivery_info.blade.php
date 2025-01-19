@extends('frontend.layout')

@section('content')
    <!--title page-->

    <div class="breacrumb-section banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ __('front.home') }}</a>
                        <span>Delivery Info</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="pt-5 mb-4">

        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row aiz-steps arrow-divider">
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ __('front.1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ __('front.2. Shipping info') }}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ __('front.3. Delivery info') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ __('front.4. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ __('front.5. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 gry-bg">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-10 mx-auto">
                    <form class="form-default" action="{{ route('checkout.store_delivery_info') }}" role="form"
                        method="POST">
                        @csrf
                        @php
                            $admin_products = [];
                            $seller_products = [];
                            foreach ($carts as $key => $cartItem) {
                                $product = \App\Models\Product::find($cartItem['product_id']);

                                if ($product->added_by == 'admin') {
                                    array_push($admin_products, $cartItem['product_id']);
                                } else {
                                    $product_ids = [];
                                    if (isset($seller_products[$product->user_id])) {
                                        $product_ids = $seller_products[$product->user_id];
                                    }
                                    array_push($product_ids, $cartItem['product_id']);
                                    $seller_products[$product->user_id] = $product_ids;
                                }
                            }
                        @endphp

                        @if (!empty($admin_products))
                            <div class="card mb-3 shadow-sm border-0 rounded">
                                <div class="card-header p-3">
                                    <h5 class="fs-16 fw-600 mb-0">
                                        {{ __('front.Products') }}</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($admin_products as $key => $cartItem)
                                            @php
                                                $product = \App\Models\Product::find($cartItem);
                                            @endphp
                                            <li class="list-group-item">
                                                <div class="d-flex gap-3">
                                                    <span class="mr-2">
                                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                            class="img-fit size-60px rounded"
                                                            alt="{{ $product->getTranslation('name') }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('images/fe-2.jpg') }}'">
                                                    </span>
                                                    <span
                                                        class="fs-14 opacity-60">{{ $product->getTranslation('name') }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="row items-center border-top pt-3 text-right">
                                        <div class="col-md-3">
                                            <h6 class="fs-15 fw-600">{{ __('front.Choose Delivery Type') }}</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body text-center">
                                                <div class="row gutters-5 items-center">
                                                    <div class="col-4">
                                                        <label class="aiz-megabox d-block bg-white mb-0">
                                                            <input type="radio"
                                                                name="shipping_type_{{ \App\Models\User::where('user_type', 'admin')->first()->id }}"
                                                                value="home_delivery" onchange="show_pickup_point(this)"
                                                                data-target=".pickup_point_id_admin">
                                                                <span class="d-block p-3 aiz-megabox-elem " >
                                                                    <img src="{{ static_asset('assets/img/cards/cod.png') }}"
                                                                        class="img-fluid mb-2 w-150px h-50px">
                                                                    <span class=" mt-1 d-block"></span>
                                                                    <span
                                                                        class="d-block fw-600">{{ __('front.Home Delivery') }}</span>
                                                                </span>
                                                            
                                                        </label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="aiz-megabox d-block bg-white mb-0">
                                                            <input type="radio"
                                                                name="shipping_type_{{ \App\Models\User::where('user_type', 'admin')->first()->id }}"
                                                                id="aramex" value="aramex" class="online_payment">
                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                <img src="{{ static_asset('assets/img/cards/aramex.png') }}"
                                                                    class="img-fluid mb-2 w-150px h-50px">
                                                                <span class=" mt-1 d-block"></span>
                                                                <span
                                                                    class="d-block fw-600">{{ __('Aramex') }}</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    @if (\App\Models\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                        <div class="col-4">
                                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                                <input type="radio"
                                                                    name="shipping_type_{{ \App\Models\User::where('user_type', 'admin')->first()->id }}"
                                                                    value="pickup_point" onchange="show_pickup_point(this)"
                                                                    data-target=".pickup_point_id_admin">
                                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                                    <span
                                                                        class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                    <span
                                                                        class="flex-grow-1 pl-3 fw-600">{{ __('front.Local Pickup') }}</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-4 pickup_point_id_admin d-none">
                                                <select class="form-control aiz-selectpicker"
                                                    name="pickup_point_id_{{ \App\Models\User::where('user_type', 'admin')->first()->id }}"
                                                    data-live-search="true">
                                                    <option>{{ __('front.Select your nearest pickup point') }}</option>
                                                    @foreach (\App\Models\PickupPoint::where('pick_up_status', 1)->get() as $key => $pick_up_point)
                                                        <option value="{{ $pick_up_point->id }}"
                                                            data-content="<span class='d-block'>
                                                                        <span class='d-block fs-16 fw-600 mb-2'>{{ $pick_up_point->getTranslation('name') }}</span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ $pick_up_point->getTranslation('address') }}</span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i>{{ $pick_up_point->phone }}</span>
                                                                    </span>">
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                        @if (!empty($seller_products))
                            @foreach ($seller_products as $key => $seller_product)
                                <div class="card mb-3 shadow-sm border-0 rounded">
                                    <div class="card-header p-3">
                                        <h5 class="fs-16 fw-600 mb-0">
                                            {{ \App\Models\Shop::where('user_id', $key)->first()->name }}
                                            {{ __('front.Products') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($seller_product as $cartItem)
                                                @php
                                                    $product = \App\Models\Product::find($cartItem);
                                                @endphp
                                                <li class="list-group-item">
                                                    <div class="d-flex">
                                                        <span class="mr-2">
                                                            <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                class="img-fit size-60px rounded"
                                                                alt="{{ $product->getTranslation('name') }}">
                                                        </span>
                                                        <span
                                                            class="fs-14 opacity-60">{{ $product->getTranslation('name') }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="row border-top pt-3">
                                            <div class="col-md-6">
                                                <h6 class="fs-15 fw-600">{{ __('front.Choose Delivery Type') }}</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body text-center">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                                <input type="radio"
                                                                    name="shipping_type_{{ $key }}"
                                                                    value="home_delivery"
                                                                    onchange="show_pickup_point(this)"
                                                                    data-target=".pickup_point_id_{{ $key }}"
                                                                    checked>
                                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                                    <span
                                                                        class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                    <span
                                                                        class="flex-grow-1 pl-3 fw-600">{{ __('front.Home Delivery') }}</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                                <input type="radio"
                                                                    name="shipping_type_{{ $key }}"
                                                                    id="aramex" value="aramex">
                                                                <span class="d-block p-3 aiz-megabox-elem">
                                                                    <img src="{{ static_asset('assets/img/cards/aramex.png') }}"
                                                                        class="img-fluid mb-2 w-150px h-50px">
                                                                    <span class="aiz-rounded-check mt-1 d-block"></span>
                                                                    <span
                                                                        class="d-block fw-600">{{ __('front.Aramex') }}</span>
                                                                </span>
                                                            </label>
                                                        </div>

                                                        @if (\App\Models\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                            @if (is_array(json_decode(\App\Models\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                                <div class="col-4">
                                                                    <label class="aiz-megabox d-block bg-white mb-0">
                                                                        <input type="radio"
                                                                            name="shipping_type_{{ $key }}"
                                                                            value="pickup_point"
                                                                            onchange="show_pickup_point(this)"
                                                                            data-target=".pickup_point_id_{{ $key }}">
                                                                        <span class="d-flex p-3 aiz-megabox-elem">
                                                                            <span
                                                                                class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                            <span
                                                                                class="flex-grow-1 pl-3 fw-600">{{ __('front.Local Pickup') }}</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                @if (\App\Models\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                    @if (is_array(json_decode(\App\Models\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                        <div class="mt-4 pickup_point_id_{{ $key }} d-none">
                                                            <select class="form-control aiz-selectpicker"
                                                                name="pickup_point_id_{{ $key }}"
                                                                data-live-search="true">
                                                                <option>{{ __('front.Select your nearest pickup point') }}
                                                                </option>
                                                                @foreach (\App\Models\PickupPoint::where('pick_up_status', 1)->get() as $key => $pick_up_point)
                                                                    <option value="{{ $pick_up_point->id }}"
                                                                        data-content="<span class='d-block'>
                                                                                    <span class='d-block fs-16 fw-600 mb-2'>{{ $pick_up_point->getTranslation('name') }}</span>
                                                                                    <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ $pick_up_point->getTranslation('address') }}</span>
                                                                                    <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i>{{ $pick_up_point->phone }}</span>
                                                                                </span>">
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div id="delivery-fees" style="margin-top: 10px;"></div>

                        <div class="pt-4 d-flex justify-content-between align-items-center">
                            <a href="{{ route('home') }}">
                                <i class="la la-angle-left"></i>
                                {{ __('front.Return to shop') }}
                            </a>
                            <button type="submit"
                                class="btn fw-600 btn-primary">{{ __('front.Continue to Payment') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection



@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#aramex').on('change', function() {
                if ($(this).is(':checked')) {

                    $.ajax({
                        url: '{{ route('create-shipment') }}', // URL to send request
                        method: 'POST', // HTTP method
                        data: {
                            _token: "{{ csrf_token() }}", // Include CSRF token
                            user_id: {!! json_encode($carts[0]['user_id']) !!}
                        },

                        success: function(response) {

                            if (response.success) {

                                $('#delivery-fees').html(
                                    `Delivery Fees: ${response.deliveryFees} SAR`);
                            } else {
                                $('#delivery-fees').html('Failed to fetch delivery fees.');
                            }
                        },
                        error: function() {
                            $('#delivery-fees').html(
                                'An error occurred while fetching delivery fees.');

                        }
                    });
                }
            });
        });



        function display_option(key) {

        }

        function show_pickup_point(el) {
            var value = $(el).val();
            var target = $(el).data('target');

            // console.log(value);

            if (value == 'home_delivery') {
                if (!$(target).hasClass('d-none')) {
                    $(target).addClass('d-none');
                }
            } else {
                $(target).removeClass('d-none');
            }
        }
    </script>
@endsection
