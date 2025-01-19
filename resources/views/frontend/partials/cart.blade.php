@php
    if (auth()->user() != null) {
        $user_id = Auth::user()->id;
        $cart = \App\Models\Cart::where('user_id', $user_id)->get();
    } else {
        $temp_user_id = Session()->get('temp_user_id');
        if ($temp_user_id) {
            $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
        }
    }
    
    $total = 0;
@endphp


    @if (isset($cart) && count($cart) > 0)

        <ul class="h-350px overflow-auto c-scrollbar-light list-group list-group-flush">
            @foreach ($cart as $key => $cartItem)
                @php
                    $product_image = null;
                    $product = \App\Models\Product::find($cartItem['product_id']);
                    $total = $total + $cartItem['price'] * $cartItem['quantity'];
                    $product_stock = $product->stocks->where('variant', $cartItem['variation'])->first();
                    if ($cartItem['variation'] != null) {
                        $product_image = $product_stock->image;
                    }
                    $image = $product_image != null ? $product_image : $product->thumbnail_img
                @endphp
                @if ($product != null)
                    <li class="list-group-item m-2 p-1 flex items-center justify-between">
                        <div class="">
                        <img src="{{ asset('images/fe-1.jpg') }}"
                            data-src="{{ uploaded_asset($product_image != null ? $product_image : 'images/fe-1.jpg') }}"
                            class="img-fit lazyload size-100px rounded" alt="{{ $product->getTranslation('name') }}">
                        <span class="" style="color:#000; font-size: 1.1em; margin-top: 5px;">
                            {{ trimString($product->getTranslation('name'), 30) }}
                        </span>
                        <br>
                        <span>
                            <span class="">{{ $cartItem['quantity'] }}x</span>
                            <span class="">{{ single_price($cartItem['price']) }}</span>

                        </span>
                    </div>
                    <div class="">
                        <span>
                            <button title="احذف المنتج" onclick="removeFromCart({{ $cartItem['id'] }})"
                                class="btn btn-sm btn-icon stop-propagation">
                                <i class="fa-solid fa-xmark"
                                    style="color: red; font-weight: bold; font-size: larger"></i>
                            </button>
                        </span>
                    </div>

                    </li>
                @endif
            @endforeach
        </ul>
        <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
            <span class="opacity-60">{{ __('المجموع الفرعي') }}</span>
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
    @else
        <div class="content">
            <p>لا يوجد منتجات فى سله المشتريات</p>
            <button id="btn-cart-back">العوده للتسوق</button>
        </div>
    @endif

