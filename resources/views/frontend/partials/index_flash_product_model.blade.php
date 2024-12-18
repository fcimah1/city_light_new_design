
        <div class="product-item">
            <div class="pi-pic">

<a href="{{ route('product', $product->slug) }}">
                <img
                    class="img-fit lazyload mx-auto h-310px h-md-310px"
                    src="{{asset('assets')}}/img/placeholder.jpg"
                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                    alt=" product image {{ $product->getTranslation('name') }}"
                    onerror="this.onerror=null;this.src='{{asset('assets')}}/img/placeholder.jpg';">

                `@if (discount_in_percentage($product) > 0)

                    <div class="sale">Sale {{ discount_in_percentage($product) }}% </div>
                @endif
</a>

                <ul>
                    <li class="w-icon active">
                        <a href="{{ route('product', $product->slug) }}"   >
                            <i class="icon_bag_alt"></i>
                        </a>
                    </li>

                    <li class="quick-view">
                        <a href="#" onclick="showAddToCartModal({{ $product->id }})">+ Quick View</a>
                    </li>
                    <li class="w-icon">
                        <a href="#" onclick="addToWishList({{ $product->id }})">
                            <i class="icon_heart_alt"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="pi-text mx-auto mx-auto">
                <div class="catagory-name">{{$product->brand->getTranslation('name')}}</div>

                @if(count($product->stocks))
                    <div class="aiz-radio-inline">

                        @foreach($product->stocks as $stock)
                            <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ $stock->variant }}" >


                                <img
                                    class="lazyload mw-100 size-60px mx-auto" style=" border-bottom: 1px solid #eb7d42;"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($stock->image) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                >






                            </label>
                        @endforeach
                    </div>
                @endif
                <a href="{{ route('product', $product->slug) }}" class="product-name h-70px h-md-70px">
                    <h5>{{$product->getTranslation('name')}}</h5>
                </a>
                <div class="product-price" >
                    @if (home_base_price($product) != home_discounted_base_price($product))

                        {{ home_discounted_base_price($product) }}
                        <span> {{ home_base_price($product) }} </span>
                    @else
                        {{ home_base_price($product) }}

                    @endif

                </div>

            </div>
        </div>



