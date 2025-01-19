<div class="box">
    <div class="image ">
        <a href="{{ route('product', $product->slug) }}">

            <img class="image-fit lazyload mx-auto h-270px h-md-310px" src="{{ asset('images/fe-1.jpg') }}"
                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                alt=" product image {{ $product->getTranslation('name') }}"
                onerror="this.onerror=null;this.src='{{ asset('images/fe-1.jpg') }}'">
        </a>

    </div>
    <div class="flex prod-details flex-col items-center justify-between h-110px">
        <div class="">
            <p>{{ $product->getTranslation('name') }}</p>
        </div>
        <div>
            <p>
                <span class="total">
                    <bdo dir="ltr">
                        @if (home_base_price($product) != home_discounted_base_price($product))
                            <span class="price"> {{ home_discounted_base_price($product) }} </span>
                            <del>{{ home_base_price($product) }} </del>
                        @else
                            <span class="price"> {{ home_base_price($product) }} </span>
                        @endif

                    </bdo></span>
            </p>

            <button onclick="window.location.href = '{{ route('product', $product->slug) }}'">اضف الى السله</button>
        </div>
    </div>
</div>
