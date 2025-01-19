@extends('frontend.layout')

@section('content')


    <div class="breacrumb-section  banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ __('front.home') }}</a>
                        <span>Checkout</span>
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
                                <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ __('front.1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ __('front.2. Shipping info') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ __('front.3. Delivery info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ __('front.4. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ __('front.5. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4 gry-bg">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-xxl-8 col-xl-10 mx-auto">
                    <form class="form-default" data-toggle="validator"
                        action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                        @csrf
                        @if (Auth::check())
                            <div class="shadow-sm bg-white p-4 rounded mb-4">
                                <div class="row gutters-5">
                                    @foreach (Auth::user()->addresses as $key => $address)
                                        <div class="col-md-6 mb-3">
                                            <label class="aiz-megabox d-block bg-white mb-0">

                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                                        @if ($address->set_default) checked @endif required
                                                        style="z-index:10;opacity:1;list-style: circle;display: block;">
                                                    <span class="flex-grow-1 pl-3 px-4 text-right">
                                                        <div>
                                                            <span class="opacity-60">{{ __('front.Address') }}:</span>
                                                            <span class="fw-600 ml-2">{{ $address->address }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="opacity-60">{{ __('front.State') }}:</span>
                                                            <span
                                                                class="fw-600 ml-2">{{ optional($address->state)->name }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="opacity-60">{{ __('front.Country') }}:</span>
                                                            <span
                                                                class="fw-600 ml-2">{{ optional($address->country)->name }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="opacity-60">{{ __('front.Phone') }}:</span>
                                                            <span class="fw-600 ml-2">{{ $address->phone }}</span>
                                                        </div>
                                                    </span>
                                                </span>
                                            </label>
                                            <div class="dropdown position-absolute left-0 top-0">
                                                <button title="Edit Address" class="btn bg-gray px-2 position-absolute left-0" type="button" id="edit_button" onclick="edit_address('{{ $address->id }}')">
                                                    <i class="la la-ellipsis-v"></i>
                                                </button>
                                                {{-- <div class="dropdown dropdown-menu dropdown-menu-right" id="edit_addr" style="margin-top: 30px; text-align: center;"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" onclick="edit_address('{{ $address->id }}')">
                                                        {{ __('front.Edit') }}
                                                    </a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                    <input type="hidden" name="checkout_type" value="logged">
                                    <div class="col-md-6 mx-auto mb-3">
                                        <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center"
                                            onclick="add_new_address()">
                                            <i class="las la-plus la-2x mb-3"></i>
                                            <div class="alpha-7">{{ __('front.Add New Address') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                                <a href="{{ route('home') }}" class="btn btn-link">
                                    <i class="las la-arrow-left"></i>
                                    {{ __('front.Return to shop') }}
                                </a>
                            </div>
                            <div class="col-md-6 text-center text-md-right">
                                <button type="submit"
                                    class="btn btn-primary fw-600">{{ __('front.Continue to Delivery Info') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    @include('frontend.partials.address_modal')
@endsection
