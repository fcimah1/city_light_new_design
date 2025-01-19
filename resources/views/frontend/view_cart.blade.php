@extends('frontend.layout')
@section('content')



    <div class="breacrumb-section banner">
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
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ __('front.1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ __('front.2. Shipping info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ __('front.3. Delivery info') }}
                                </h3>
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

    <section class="mb-4" id="cart-summary">
        <div class="container">
            @if ($carts && count($carts) > 0)
                <div class="row">
                    <div class="col-xxl-8 col-xl-10 mx-auto">
                        <div class="shadow-sm bg-white p-3 p-lg-4 rounded text-right">
                            <div class="mb-4">
                                <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 pb-3 text-center">
                                    <div class="col-md-5 fw-600">{{ __('front.Product') }}</div>
                                    <div class="col fw-600">{{ __('front.Price') }}</div>
                                    <div class="col fw-600">{{ __('front.Tax') }}</div>
                                    <div class="col fw-600">{{ __('front.Quantity') }}</div>
                                    <div class="col fw-600">{{ __('front.Total') }}</div>
                                    <div class="col-auto fw-600">{{ __('front.Remove') }}</div>
                                </div>
                                <ul class="list-group list-group-flush text-center">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($carts as $key => $cartItem)
                                        @php
                                            $product_image = null;
                                            $product = \App\Models\Product::find($cartItem['product_id']);
                                            $product_stock = $product->stocks
                                                ->where('variant', $cartItem['variation'])
                                                ->first();
                                            $total =
                                                $total +
                                                ($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity'];
                                            $product_name_with_choice = $product->getTranslation('name');
                                            if ($cartItem['variation'] != null) {
                                                $product_name_with_choice =
                                                    $product->getTranslation('name') .
                                                    ' - (Color) :  ' .
                                                    $cartItem['variation'];
                                                $product_image = $product_stock->image;
                                            }
                                        @endphp
                                        <li class="list-group-item px-0 px-lg-3">
                                            <div class="row gutters-5 text-right">
                                                <div class="col-lg-5 d-flex gap-2">
                                                    <span class="mr-2 ml-0">
                                                        <img src="{{ uploaded_asset($product_image != null ? $product_image : $product->thumbnail_img) }}"
                                                            class="img-fit size-60px rounded"
                                                            alt="{{ $product->getTranslation('name') }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('images/fe-1.jpg') }}'">
                                                    </span>
                                                    <span class="fs-14 opacity-60">{{ $product_name_with_choice }}</span>
                                                </div>

                                                <div class="col-lg col-4 order-1 order-lg-0 my-3 my-lg-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-lg-none">{{ __('front.Price') }}</span>
                                                    <span
                                                        class="fw-600 fs-16">{{ single_price($cartItem['price']) }}</span>
                                                </div>
                                                <div class="col-lg col-4 order-2 order-lg-0 my-3 my-lg-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-lg-none">{{ __('front.Tax') }}</span>
                                                    <span class="fw-600 fs-16">{{ single_price($cartItem['tax']) }}</span>
                                                </div>

                                                <div class="col-lg col-6 order-4 order-lg-0">
                                                    @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                                        <div
                                                            class="row no-gutters align-items-center aiz-plus-minus mr-2 ml-0">
                                                            <button
                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                type="button" data-type="minus"
                                                                data-field="quantity[{{ $cartItem['id'] }}]">
                                                                <i class="las la-minus"></i>
                                                            </button>
                                                            <input type="number" name="quantity[{{ $cartItem['id'] }}]"
                                                                class=" border-0 text-center fs-16 input-number"
                                                                placeholder="1" value="{{ $cartItem['quantity'] }}"
                                                                min="{{ $product->min_qty }}"
                                                                max="{{ $product_stock->qty }}"
                                                                onchange="updateQuantity({{ $cartItem['id'] }}, this)">
                                                            <button
                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                type="button" data-type="plus"
                                                                data-field="quantity[{{ $cartItem['id'] }}]">
                                                                <i class="las la-plus"></i>
                                                            </button>
                                                        </div>
                                                    @elseif($product->auction_product == 1)
                                                        <span class="fw-600 fs-16">1</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg col-4 order-3 order-lg-0 my-3 my-lg-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-lg-none">{{ __('front.Total') }}</span>
                                                    <span
                                                        class="fw-600 fs-16 text-primary">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}</span>
                                                </div>
                                                <div class="col-lg-auto col-6 order-5 order-lg-0 text-left">
                                                    <a href="javascript:void(0)"
                                                        onclick="removeFromCartView(event, {{ $cartItem['id'] }})"
                                                        class="btn btn-icon btn-sm btn-soft-primary btn-circle">
                                                        <i class="las la-trash" style="color: white;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="px-3 py-2 mb-4 border-top d-flex justify-content-between">
                                <span class="opacity-60 fs-15">{{ __('front.Subtotal') }}</span>
                                <span class="fw-600 fs-17">{{ single_price($total) }}</span>
                            </div>
                            <div class="px-3 py-2 mb-4 border-top d-flex justify-content-center">
                                <p>Tax & customs fees included</p>
                            </div>
                            <div class="row align-items-center ">
                                <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                                    <a href="{{ route('home') }}" class="btn btn-link">
                                        <i class="las la-arrow-left"></i>
                                        {{ __('front.Return to shop') }}
                                    </a>
                                </div>
                                <div class="col-md-6 text-center text-md-right">
                                    @if (Auth::check())
                                        <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary fw-600">
                                            {{ __('front.Continue to Shipping') }}
                                        </a>
                                    @else
                                        <button class="btn btn-primary fw-600" id="user-login"
                                           >{{ __('front.Continue to Shipping') }}</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="shadow-sm bg-white p-4 rounded">
                            <div class="text-center p-3">
                                <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                <h3 class="h4 fw-700">{{ __('front.Your Cart is empty') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection


@section('script')
    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {

            $.post('{{ route('cart.updateQuantity') }}', {
                _token: AIZ.data.csrf,
                id: key,
                quantity: element.value
            }, function(data) {
                // console.log(data);
                
                updateNavCart(data.nav_cart_view, data.cart_count);
                $('#cart-summary').html(data.cart_view);
                initializeScripts();
            });
        }

 
    // const layer = document.getElementById("layer");

    // const userMenu = document.getElementById("user-account");

    // function initializeScripts() {
    //     // Rebind event listeners or reinitialize plugins
    //     $('.tooltip').tooltip(); // Example for a Bootstrap tooltip
    //     $('button').on('click', function() {
    //         userMenu.classList.toggle("show");
    //         layer.classList.toggle("lay-show");
    //         console.log('Button clicked');
    //     });

    //     layer.addEventListener("click", () => {
    //         layer.classList.toggle("lay-show");
    //         userMenu.classList.remove("show");
    //     });
    // }

        // Country Code
        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if (country.iso2 == 'bd') {
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if (selectedCountryData.iso2 == 'bd') {
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);

        });

        function toggleEmailPhone(el) {
            if (isPhoneShown) {
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                $('input[name=phone]').val(null);
                isPhoneShown = false;
                $(el).html('{{ translate('Use Phone Instead') }}');
            } else {
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                $('input[name=email]').val(null);
                isPhoneShown = true;
                $(el).html('{{ translate('Use Email Instead') }}');
            }
        }

    </script>
@endsection




 