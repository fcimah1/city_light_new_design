<a href="javascript:void(0)" class="d-flex align-items-center text-reset h-100" data-toggle="dropdown"
    data-display="static">
    <i class="icon_bag_alt la-2x"></i>
    <span class="" id="cart_items">
    </span>
</a>



{{-- <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg p-0 stop-propagation"> --}}
<div class="dropdown-menu dropdown-menu-lg p-0 stop-propagation dropdown-menu-custom">
    @if (isset($cart) && count($cart) > 0)

        {{--        old --}}
        <div class="p-3 fs-15 fw-600 p-3 border-bottom">
            {{ __('front.cart items') }}
        </div>
        <ul class="h-250px overflow-auto c-scrollbar-light list-group list-group-flush">


            @php
                $total = 0;
            @endphp
            @foreach ($cart as $key => $cartItem)
                @php
                    $product_image = null;
                    $product = \App\Models\Product::find($cartItem['product_id']);
                    $total = $total + $cartItem['price'] * $cartItem['quantity'];
                    $product_stock = $product->stocks->where('variant', $cartItem['variation'])->first();
                    if ($cartItem['variation'] != null) {
                        $product_image = $product_stock->image;
                    }
                @endphp
                @if ($product != null)
                    <li class="list-group-item">
                        <img src="{{ asset('assets') }}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($product_image != null ? $product_image : $product->thumbnail_img) }}"
                            class="img-fit lazyload size-60px rounded" alt="{{ $product->getTranslation('name') }}">
                        <span class="" style="color:#000; font-size: 0.5em;">
                            {{ trimString($product->getTranslation('name'), 30) }}
                        </span>
                        <br>
                        <span>
                            <span class="">{{ $cartItem['quantity'] }}x</span>
                            <span class="">{{ single_price($cartItem['price']) }}</span>

                        </span>

                        <span>
                            <button onclick="removeFromCart({{ $cartItem['id'] }})"
                                class="btn btn-sm btn-icon stop-propagation">
                                <i class="la la-trash la-bold"
                                    style="color: red; font-weight: bold; font-size: larger"></i>
                            </button>
                        </span>

                    </li>
                @endif
            @endforeach
        </ul>
        <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
            <span class="opacity-60">{{ __('front.subtotal') }}</span>
            <span class="fw-600">{{ single_price($total) }}</span>


        </div>
        <div class="px-3 py-2 text-center border-top">
            <p>Tax & customs fees included</p>
        </div>
        <div class="px-3 py-2 text-center border-top">



            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="{{ route('cart') }}" class="btn btn-soft-primary btn-sm" style="color: white">
                        {{ __('front.view cart') }}
                    </a>
                </li>
                @if (Auth::check())
                    <li class="list-inline-item">
                        <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary btn-sm"
                            style="color: white">
                            {{ __('front.checkout') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        {{--  end old --}}
    @else
        <div class="text-center p-3">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h6 fw-700">{{ __('front.your cart is empty') }}</h3>
        </div>
    @endif

</div>
