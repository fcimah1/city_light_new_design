@extends('frontend.layout')

@section('content')

    <div class="breacrumb-section banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> {{__('front.home')}}</a>
                        <span>Payment Select</span>
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
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ __('front.3. Delivery info') }}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ __('front.4. Payment') }}</h3>
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
    <section class="mb-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-lg-8">
                    <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST"
                        id="checkout-form">
                        @csrf
                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">

                        <div class="card shadow-sm border-0 rounded">
                            <div class="card-header p-3">
                                <h3 class="fs-16 fw-600 mb-0">
                                    {{ __('front.Select a payment option') }}
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-xxl-8 col-xl-10 mx-auto">
                                        <div class="row gutters-10">
                                            @if (get_setting('stripe_payment') != 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="stripe" class="online_payment" type="radio"
                                                               name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                                                 class="img-fluid mb-2 w-150px h-70px">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ __('front.Stripe') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif

                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="tabby" class="online_payment" type="radio"
                                                               name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/tabby.png') }}"
                                                                 class="img-fluid mb-2 w-150px h-70px">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ __('front.Tabby') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>

                                               <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="tamara" class="online_payment" type="radio"
                                                               name="payment_option" >
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/tamara.png') }}"
                                                                 class="img-fluid mb-2 w-150px h-70px">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ __('front.Tamara') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>


{{--                                            @if (get_setting('paypal_payment') != 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class=" d-block mb-3">--}}
{{--                                                        <input value="paypal" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/paypal.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Paypal') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                        --}}
{{--                                            @if (get_setting('sslcommerz_payment') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="sslcommerz" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/sslcommerz.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.sslcommerz') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('instamojo_payment') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="instamojo" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/instamojo.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Instamojo') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('razorpay') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="razorpay" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/rozarpay.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Razorpay') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('paystack') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="paystack" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/paystack.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Paystack') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('voguepay') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="voguepay" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/vogue.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.VoguePay') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('payhere') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="payhere" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/payhere.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.payhere') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('ngenius') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="ngenius" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/ngenius.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.ngenius') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('iyzico') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="iyzico" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/iyzico.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Iyzico') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('nagad') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="nagad" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/nagad.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Nagad') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('bkash') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="bkash" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/bkash.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Bkash') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('aamarpay') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="aamarpay" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/aamarpay.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Aamarpay') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('authorizenet') != 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class=" d-block mb-3">--}}
{{--                                                        <input value="authorizenet" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/authorizenet.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.AuthorizeNet') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('payku') == 1)--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="payku" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/payku.png') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Payku') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (addon_is_activated('african_pg'))--}}
{{--                                                @if (get_setting('mpesa') == 1)--}}
{{--                                                    <div class="col-6 col-md-4">--}}
{{--                                                        <label class="aiz-megabox d-block mb-3">--}}
{{--                                                            <input value="mpesa" class="online_payment" type="radio"--}}
{{--                                                                name="payment_option" checked>--}}
{{--                                                            <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                                <img src="{{ static_asset('assets/img/cards/mpesa.png') }}"--}}
{{--                                                                    class="img-fluid mb-2">--}}
{{--                                                                <span class="d-block text-center">--}}
{{--                                                                    <span--}}
{{--                                                                        class="d-block fw-600 fs-15">{{ __('front.mpesa') }}</span>--}}
{{--                                                                </span>--}}
{{--                                                            </span>--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                                @if (get_setting('flutterwave') == 1)--}}
{{--                                                    <div class="col-6 col-md-4">--}}
{{--                                                        <label class="aiz-megabox d-block mb-3">--}}
{{--                                                            <input value="flutterwave" class="online_payment" type="radio"--}}
{{--                                                                name="payment_option" checked>--}}
{{--                                                            <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                                <img src="{{ static_asset('assets/img/cards/flutterwave.png') }}"--}}
{{--                                                                    class="img-fluid mb-2">--}}
{{--                                                                <span class="d-block text-center">--}}
{{--                                                                    <span--}}
{{--                                                                        class="d-block fw-600 fs-15">{{ __('front.flutterwave') }}</span>--}}
{{--                                                                </span>--}}
{{--                                                            </span>--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                                @if (get_setting('payfast') == 1)--}}
{{--                                                    <div class="col-6 col-md-4">--}}
{{--                                                        <label class="aiz-megabox d-block mb-3">--}}
{{--                                                            <input value="payfast" class="online_payment" type="radio"--}}
{{--                                                                name="payment_option" checked>--}}
{{--                                                            <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                                <img src="{{ static_asset('assets/img/cards/payfast.png') }}"--}}
{{--                                                                    class="img-fluid mb-2">--}}
{{--                                                                <span class="d-block text-center">--}}
{{--                                                                    <span--}}
{{--                                                                        class="d-block fw-600 fs-15">{{ __('front.payfast') }}</span>--}}
{{--                                                                </span>--}}
{{--                                                            </span>--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                            @if (addon_is_activated('paytm'))--}}
{{--                                                <div class="col-6 col-md-4">--}}
{{--                                                    <label class="aiz-megabox d-block mb-3">--}}
{{--                                                        <input value="paytm" class="online_payment" type="radio"--}}
{{--                                                            name="payment_option" checked>--}}
{{--                                                        <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                            <img src="{{ static_asset('assets/img/cards/paytm.jpg') }}"--}}
{{--                                                                class="img-fluid mb-2">--}}
{{--                                                            <span class="d-block text-center">--}}
{{--                                                                <span--}}
{{--                                                                    class="d-block fw-600 fs-15">{{ __('front.Paytm') }}</span>--}}
{{--                                                            </span>--}}
{{--                                                        </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if (get_setting('cash_payment') == 1)--}}
{{--                                                @php--}}
{{--                                                    $digital = 0;--}}
{{--                                                    $cod_on = 1;--}}
{{--                                                    foreach ($carts as $cartItem) {--}}
{{--                                                        $product = \App\Models\Product::find($cartItem['product_id']);--}}
{{--                                                        if ($product['digital'] == 1) {--}}
{{--                                                            $digital = 1;--}}
{{--                                                        }--}}
{{--                                                        if ($product['cash_on_delivery'] == 0) {--}}
{{--                                                            $cod_on = 0;--}}
{{--                                                        }--}}
{{--                                                    }--}}
{{--                                                @endphp--}}
{{--                                                @if ($digital != 1 && $cod_on == 1)--}}
{{--                                                    <div class="col-6 col-md-4">--}}
{{--                                                        <label class=" d-block mb-3">--}}
{{--                                                            <input value="cash_on_delivery" class="online_payment"--}}
{{--                                                                type="radio" name="payment_option" checked>--}}
{{--                                                            <span class="d-block p-3 aiz-megabox-elem">--}}
{{--                                                                <img src="{{ static_asset('assets/img/cards/cod.png') }}"--}}
{{--                                                                    class="img-fluid mb-2">--}}
{{--                                                                <span class="d-block text-center">--}}
{{--                                                                    <span--}}
{{--                                                                        class="d-block fw-600 fs-15">{{ __('front.Cash on Delivery') }}</span>--}}
{{--                                                                </span>--}}
{{--                                                            </span>--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
                                            @if (Auth::check())
                                                @if (addon_is_activated('offline_payment'))
                                                    @foreach (\App\Models\ManualPaymentMethod::all() as $method)
                                                        <div class="col-6 col-md-4">
                                                            <label class=" d-block mb-3">
                                                                <input value="{{ $method->heading }}" type="radio"
                                                                    name="payment_option"
                                                                    onchange="toggleManualPaymentData({{ $method->id }})"
                                                                    data-id="{{ $method->id }}" checked>
                                                                <span class="d-block p-3 aiz-megabox-elem">
                                                                    <img src="{{ uploaded_asset($method->photo) }}"
                                                                        class="img-fluid mb-2">
                                                                    <span class="d-block text-center">
                                                                        <span
                                                                            class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                    @foreach (\App\Models\ManualPaymentMethod::all() as $method)
                                                        <div id="manual_payment_info_{{ $method->id }}"
                                                            class="d-none">
                                                            @php echo $method->description @endphp
                                                            @if ($method->bank_info != null)
                                                                <ul>
                                                                    @foreach (json_decode($method->bank_info) as $key => $info)
                                                                        <li>{{ __('front.Bank Name') }} -
                                                                            {{ $info->bank_name }},
                                                                            {{ __('front.Account Name') }}
                                                                            - {{ $info->account_name }},
                                                                            {{ __('front.Account Number') }}
                                                                            - {{ $info->account_number }},
                                                                            {{ __('front.Routing Number') }}
                                                                            - {{ $info->routing_number }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if (addon_is_activated('offline_payment'))
                                    <div class="bg-white border mb-3 p-3 rounded text-left d-none">
                                        <div id="manual_payment_description">

                                        </div>
                                    </div>
                                @endif
                                @if (Auth::check() && get_setting('wallet_system') == 1)
                                    <div class="separator mb-3">
                                        <span class="bg-white px-3">
                                            <span class="opacity-60">{{ __('front.Or') }}</span>
                                        </span>
                                    </div>
                                    <div class="text-center py-4">
                                        <div class="h6 mb-3">
                                            <span class="opacity-80">{{ __('front.Your wallet balance :') }}</span>
                                            <span
                                                class="fw-600">{{ single_price(Auth::user()->balance) }}</span>
                                        </div>
                                        @if (Auth::user()->balance < $total)
                                            <button type="button" class="btn btn-secondary" disabled>
                                                {{ __('front.Insufficient balance') }}
                                            </button>
                                        @else
                                            <button type="button" onclick="use_wallet()" class="btn btn-primary fw-600">
                                                {{ __('front.Pay with wallet') }}
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="pt-3">
                        <label class="aiz-checkbox">
                            <input type="checkbox" required id="agree_checkbox">
                            <span class="aiz-square-check"></span>
                            <span>{{ __('front.I agree to the')}}</span>
                        </label>
                        <a href="{{ route('terms') }}">{{ __('front.terms and conditions')}}</a>,
                        <a href="{{ route('returnpolicy') }}">{{ __('front.return policy')}}</a> &
                        <a href="{{ route('privacypolicy') }}">{{ __('front.privacy policy')}}</a>
                    </div> --}}

                        <div class="row align-items-center pt-3">
                            <div class="col-6">
                                <a href="{{ route('home') }}" class="link link--style-3">
                                    <i class="las la-arrow-left"></i>
                                    {{ __('front.Return to shop') }}
                                </a>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" onclick="submitOrder(this)"
                                    class="btn btn-primary fw-600">{{ __('front.Complete Order') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0" id="cart_summary">
                    @include('frontend.partials.cart_summary')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            // if($('#agree_checkbox').is(":checked")){
            $('#checkout-form').submit();
            // }else{
            //     AIZ.plugins.notify('danger','{{ __('front.You need to agree with our policies') }}');
            // }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            // if ($('#agree_checkbox').is(":checked")) {
            $('#checkout-form').submit();
            // } else {
            // AIZ.plugins.notify('danger', '{{ __('front.You need to agree with our policies') }}');
            // $(el).prop('disabled', false);
            // }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }

        $(document).on("click", "#coupon-apply", function() {
            var data = new FormData($('#apply-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.apply_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    AIZ.plugins.notify(data.response_message.response, data.response_message.message);
                    //                    console.log(data.response_message);
                    $("#cart_summary").html(data.html);
                }
            })
        });

        $(document).on("click", "#coupon-remove", function() {
            var data = new FormData($('#remove-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.remove_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $("#cart_summary").html(data);
                }
            })
        })
    </script>
@endsection
