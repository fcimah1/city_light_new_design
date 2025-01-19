<div class="modal-body p-4 c-scrollbar-ligh">
    {{-- <div class="product-single-quick-view"> --}}
    <div class="popup">
        <div class="images">
            <img class="image-fit lazyload mx-auto h-270px h-md-310px" src="{{ asset('images/fe-1.jpg') }}"
                data-src="{{ $product->thumbnail_img != null ? uploaded_asset($product->thumbnail_img) : '' }}"
                alt=" product image {{ $product->getTranslation('name') }}"
                onerror="this.onerror=null;this.src='{{ asset('images/fe-2.jpg') }}'">
            <button>
                <a href="{{ route('product', $product->slug) }}">
                    view details
                </a>
            </button>
        </div>
        <div class="details">
            <h4> {{ $product->getTranslation('name') }} </h4>
            @if ($product->brand != null)
                <a href="{{ route('products.brand', $product->brand->slug) }}">
                    <img src="{{ $product->brand->getTranslation('logo') != null ? uploaded_asset($product->brand->getTranslation('logo')) : asset('images/dlight.png') }}"
                        alt="{{ $product->brand->getTranslation('name') }} " />
                </a>
            @endif
            <div class="rating">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>

                <i class="fa-regular fa-star"></i>
                <p>( <span>1</span>تقييم العملاء )</p>
            </div>
            <div class="price">
                @if (home_price($product) != home_discounted_price($product))
                    <div class="row no-gutters mt-3">

                        <div class="col-12">
                            <div class="fs-20 opacity-60">
                                <del>
                                    {{ home_price($product) }}
                                    {{-- @if ($product->unit != null)
                                        <span>/{{ $product->getTranslation('unit') }}</span>
                                    @endif --}}
                                </del>
                            </div>
                        </div>
                    </div>

                    <div class="row no-gutters mt-2">
                        <div class="col-2">
                            <div class="opacity-50">{{ __('front.Discount Price') }}:</div>
                        </div>
                        <div class="col-10">
                            <div class="">
                                <strong class="h2 fw-600 text-primary">
                                    <span>
                                        {{ home_discounted_price($product) }}
                                    </span>
                                </strong>
                                {{-- @if ($product->unit != null) --}}
                                {{-- <span class="opacity-70">/{{ $product->getTranslation('unit') }}</span> --}}
                                {{-- @endif --}}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row no-gutters mt-3">

                        <div class="col-12">
                            <div class="">
                                <strong class="h2 fw-600 text-primary">
                                    <span>
                                        {{ home_discounted_price($product) }}
                                    </span>
                                </strong>
                                {{-- <span class="opacity-70">/{{ $product->unit }}</span> --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            {{-- <div class="price">
                <p><del>817 ر.س</del> <span>480 ر.س</span></p>
            </div> --}}
            <ul class="features-prod">
                <li>ضمان سنة من سيتى لايت ضد عيوب الصناعة.</li>
                <li>استرجاع مجاني خلال ١٤ يوم من تاريخ الاستلام.</li>
                <li>سعر المنتج لا يشمل اللمبات.</li>
            </ul>


            @php
                $qty = 0;
                foreach ($product->stocks as $key => $stock) {
                    $qty += $stock->qty;
                }
            @endphp


            <form id="option-choice-form">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">

                <!-- Quantity + Add to cart -->
                @if ($product->digital != 1)

                    @if ($product->choice_options != null)
                        @foreach (json_decode($product->choice_options) as $key => $choice)
                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="opacity-50 mt-2 ">
                                        {{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}:
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="aiz-radio-inline">
                                        @foreach ($choice->values as $key => $value)
                                            <label class="aiz-megabox pl-0 mr-2">
                                                <input type="radio" name="attribute_id_{{ $choice->attribute_id }}"
                                                    value="{{ $value }}"
                                                    @if ($key == 0) checked @endif>
                                                <span
                                                    class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                    {{ $value }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if (count(json_decode($product->colors)) > 0)
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="opacity-50 mt-2">{{ __('اللون') }}:</div>
                            </div>
                            <div class="col-10">
                                <div class="aiz-radio-inline flex">
                                    @foreach (json_decode($product->colors) as $key => $color)
                                        @php
                                            $colorName = \App\Models\Color::where('code', $color)->first()->name;
                                        @endphp
                                        <label class="aiz-megabox pl-0 mr-2 flex" data-toggle="tooltip"
                                            data-title="{{ $colorName }}">
                                            <input type="radio" name="color" value="{{ $colorName }}"
                                                @if ($key == 0) checked @endif>
                                            <span
                                                class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                @foreach ($product->stocks as $stock)
                                                    @if ($stock->variant == $colorName)
                                                        <img class="lazyload mw-100 size-80px mx-auto"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($stock->image) }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                    @endif
                                                @endforeach
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <hr>
                    @endif
                    <div class=" no-gutters">
                        <div class="">
                            <div class="avialable-amount opacity-60">
                                @if ($product->stock_visibility_state == 'quantity')
                                    <div class="availability"><i class="fa-solid fa-check"></i>
                                        {{ __('متوفر') }} &nbsp;
                                        (<span id="available-quantity">{{$qty}}</span>)
                                    </div>
                                @elseif($product->stock_visibility_state == 'text' && $qty >= 1)
                                    (<span id="available-quantity">{{ __('front.In Stock') }}</span>)
                                @endif
                            </div>
                        </div>
                        <div class=" quantity_button">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="amount">
                                    <div class="counter  aiz-plus-minus">
                                        <button type="button" data-type="minus" data-field="quantity"
                                            onclick="getVariantPrice()">-</button>
                                        <input type="number" name="quantity" style="text-align: center;"
                                            class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                            placeholder="1" value="{{ $product->min_qty }}"
                                            min="{{ $product->min_qty }}" max="10">
                                        <button type="button" data-type="plus" data-field="quantity"
                                            onclick="getVariantPrice()">+</button>
                                    </div>
                                    @if ($qty < $product->min_qty)
                                    <button type="button" class="out-of-stock" disabled>
                                      <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
                                  </button>
                                @else
                                    <button type="button" class="add-to-cart" onclick="addToCart()">اضف الى السله</button>
                                    <button type="button" class="buy-now" onclick="buyNow()">اشترى الان</button>
                                @endif
                            </div>

                            </div>
                        </div>
                    </div>

                    <hr>
                @endif
            </form>
            
        </div>
    </div>

    <script type="text/javascript">
        $('#option-choice-form input').on('change', function() {
            getVariantPrice();
        });
    </script>
